const path = require('path');
const replace = require("replace");
const version = require('./package.json').version;
const fs = require('fs');
const archiver = require('archiver');

replace({
    regex: "[/d]+/.[/d]+/.[/d]+",
    replacement: version,
    paths: [
        './README.MD',
        './pkg_jodit.xml',
        './manifest.xml',
        './plugins/editors/jodit/jodit.php',
        './plugins/editors/jodit/jodit.xml',
        './update.xml',
        './plugins/editors/jodit/en-GB.plg_editors_jodit.ini',
        './plugins/editors/jodit/en-GB.plg_editors_jodit.sys.ini',
    ],
    recursive: true,
    silent: true,
});

replace({
    regex: "This software is licensed under the MIT license: http://opensource.org/licenses/MIT",
    replacement: 'GNU General Public License version 2 or later; see LICENSE',
    paths: [
        './administrator/components/com_jodit/helpers/abeautifulsite/simpleimage/src/abeautifulsite/SimpleImage.php',
    ],
    recursive: true,
    silent: true,
});

const license = `<?PHP
/**
 * @package    jodit
 *
 * @author     Valeriy Chupurnov <chupurnov@gmail.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE
 * @link       https://xdsoft.net/jodit/
 */
 
defined('_JEXEC') or die;
?>`;

function appendCopyrright(appendFile){
    if (/\.php$/.test(appendFile)) {
        let data = fs.readFileSync(appendFile,  "utf8");
        if (data.indexOf('@license') === -1) {
            fs.writeFileSync(appendFile, license + data);
            data = license + data;
        }
        if (data.indexOf('_JEXEC') === -1) {
            fs.writeFileSync(appendFile, data.replace(/^<\?php/, '<?php\ndefined(\'_JEXEC\') or die;\n'));
        }
    }
}

function eachFile(folder) {
    fs.readdirSync(folder).forEach(file => {
        let st = fs.statSync(folder + '/' + file);
        if (st.isDirectory()) {
            eachFile(folder + '/' + file);
        } else {
            appendCopyrright(folder + '/' + file);
        }
    })
}
eachFile(__dirname);



function zip(zipfile, pathes) {
    return new Promise(function (resolve, reject) {
        let output = fs.createWriteStream(__dirname + '/' + zipfile);
        let archive = archiver('zip', {
            zlib: { level: 7 } // Sets the compression level.
        });
        archive.pipe(output);

        Object.keys(pathes).forEach((pth) => {
            let st = fs.statSync(__dirname + '/' + pth);
            if (st.isDirectory()) {
                archive.directory(__dirname + '/' + pth, pathes[pth]);
            } else {
                archive.file(__dirname + '/' + pth, {name: pathes[pth]});
            }
        });

        output.on('close', resolve);
        output.on('error', reject);

        archive.finalize();
    });
}

zip('tmp/plg_editors_jodit.zip', {
    'plugins/editors/jodit/': '/'
})
.then(() => {
    console.log('Plugin was builded');
    return zip('tmp/com_jodit.zip', {
        'administrator/': 'administrator/',
        'media/': 'media/',
        'node_modules/jodit/build/': 'media/com_jodit/js/jodit/',
        'node_modules/jodit-play/build/': 'media/com_jodit/js/jodit-play/',
        'manifest.xml': 'manifest.xml',
    })
})
.then(() => {
    console.log('Component was builded');
    return zip('tmp/pkg_jodit.zip', {
        'tmp/plg_editors_jodit.zip': 'plg_editors_jodit.zip',
        'tmp/com_jodit.zip': 'com_jodit.zip',
        'pkg_jodit.xml': 'pkg_jodit.xml',
    })
})
.then(() => {
    console.log('Package was builded');
    fs.unlink('tmp/plg_editors_jodit.zip', function () {
        fs.unlink('tmp/com_jodit.zip', function () {
            console.log('Temp files were deleted');
        });
    });
})
.catch((error) => {
    throw error
});








