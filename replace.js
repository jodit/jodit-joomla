var replace = require("replace");
var version = require('./package.json').version;

replace({
    regex: "[\\d]+\\.[\\d]+\\.[\\d]+",
    replacement: version,
    paths: [
        './jodit.xml',
        './jodit.php',
        './update.xml',
        './en-GB.plg_editors_jodit.ini',
        './en-GB.plg_editors_jodit.sys.ini',
    ],
    recursive: true,
    silent: false,
});