# Jodit playground
Special tool for interactive creating [Jodit](https://xdsoft.net/jodit/) config.


## Install
```bash
$ npm install jodit jodit-play --save
```
# Config
```html
<script>
 window.JoditPlayConfig = {
	showCode: true,
	showEditor: true,
	showButtonsTab: true,
	setCode: console.log,
	setConfig: console.log,
	initialConfig: {
		autofocus: true
	},
};
</script>
```

# layout
```html
<link rel="stylesheet" href="/node_modules/jodit/build/jodit.min.css">
<link href="/node_modules/jodit-play/build/static/css/main.css" rel="stylesheet"></head><body>
<noscript>You need to enable JavaScript to run this app.</noscript>
<div style="width:1200px;margin:0 auto" id="root"></div>
<script type="text/javascript" src="/node_modules/jodit-play/build/static/js/main.js"></script>
```


