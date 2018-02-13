var replace = require("replace");
var version = require('./package.json').version;

replace({
    regex: "[\\d]+\\.[\\d]+\\.[\\d]+",
    replacement: version,
    paths: [
        './jodit.xml',
        './jodit.php',
        './update.xml',
    ],
    recursive: true,
    silent: false,
});