const path = require('path');

const replace = require("replace");
const version = require('./package.json').version;

replace({
    regex: "[\\d]+\\.[\\d]+\\.[\\d]+",
    replacement: version,
    paths: [
        './README.MD',
        './pkg_jodit.xml',
        './manifest.xml',
        './plugins/editors/jodit/jodit.php',
        './update.xml',
        './plugins/editors/jodit/en-GB.plg_editors_jodit.ini',
        './plugins/editors/jodit/en-GB.plg_editors_jodit.sys.ini',
    ],
    recursive: true,
    silent: true,
});

const fs = require('fs');
const archiver = require('archiver');

function zip(zipfile, pathes) {
    return new Promise(function (resolve, reject) {
        var output = fs.createWriteStream(__dirname + '/' + zipfile);
        var archive = archiver('zip', {
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








