!function(e,t){if("object"==typeof exports&&"object"==typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var r=t();for(var o in r)("object"==typeof exports?exports:e)[o]=r[o]}}(self,(function(){return(self.webpackChunkjodit_pro=self.webpackChunkjodit_pro||[]).push([[630],{798:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=r(120),n=r(145);o.Config.prototype.exportDocs={css:"",pdf:{allow:!0,options:{format:"A4",page_orientation:"portrait"}}},o.Config.prototype.controls.exportDocs={tooltip:"Export",isDisabled:function(e){return n.Dom.isEmptyContent(e.editor)},icon:r(799),list:{exportToPdf:"Export to PDF"},command:"exportToPDF"}},797:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.ExportDocs=void 0;var o=r(1),n=r(325),s=r(299),i=r(2);r(798);var a=r(800),c=r(145),u=r(122),l=r(526),p=function(e){function t(){var t=null!==e&&e.apply(this,arguments)||this;return t.requires=["license"],t.buttons=[{name:"exportDocs",group:"media"}],t}return(0,o.__extends)(t,e),t.prototype.afterInit=function(e){var r=this;e.registerCommand("exportToPDF",(function(){return(0,o.__awaiter)(r,void 0,void 0,(function(){var r,n,i,l,p,f;return(0,o.__generator)(this,(function(d){switch(d.label){case 0:r=(0,a.generateCriticalCSS)(e),n=new s.Ajax(e,(0,o.__assign)((0,o.__assign)({},null!==(f=e.o.exportDocs.ajax)&&void 0!==f?f:e.o.filebrowser.ajax),{method:"POST",responseType:"blob",onProgress:function(t){e.progressbar.show().progress(t)},data:{action:"generatePdf",html:"<style>".concat(r+e.o.exportDocs.css,"</style>").concat(t.getValue(e))}})),d.label=1;case 1:return d.trys.push([1,4,5,7]),[4,n.send()];case 2:return[4,d.sent().blob()];case 3:return i=d.sent(),(l=this.j.create.a()).href=URL.createObjectURL(i),l.download="document.pdf",l.click(),c.Dom.safeRemove(l),URL.revokeObjectURL(l.href),[3,7];case 4:return(p=d.sent()).message&&(0,u.Alert)(p.message),[3,7];case 5:return e.progressbar.progress(100),[4,e.async.delay(200)];case 6:return d.sent(),e.progressbar.hide(),[7];case 7:return[2]}}))}))}))},t.getValue=function(e){return(0,l.previewBox)(e).innerHTML},t.prototype.beforeDestruct=function(){},t}(n.Plugin);t.ExportDocs=p,i.Jodit.plugins.add("exportDocs",p)},800:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.generateCriticalCSS=void 0;var o=r(1),n=r(131);t.generateCriticalCSS=function(e){var t=function(e,t){return void 0===t&&(t=e.ownerDocument.styleSheets),(0,n.toArray)(t).map((function(e){try{return(0,n.toArray)(e.cssRules)}catch(e){}return[]})).flat().filter((function(t){try{return t&&e.matches(t.selectorText)}catch(e){}return!1}))};return new(function(){function r(r,n,s){var i=this;this.css={};var a=s||{},c=function(t){var r=t.selectorText.split(",").map((function(e){return e.trim()})).sort().join(",");!1===Boolean(i.css[r])&&(i.css[r]={});for(var n=t.style.cssText.split(/;(?![A-Za-z0-9])/),s=0;n.length>s;s++)if(n[s]){var a=n[s].split(":");a[0]=a[0].trim(),a[1]=a[1].trim(),i.css[r][a[0]]=a[1].replace(/var\(([^)]+)\)/g,(function(t,r){var n=(0,o.__read)(r.split(","),2),s=n[0],i=n[1];return(e.ew.getComputedStyle(e.editor).getPropertyValue(s.trim())||i||t).trim()}))}};!function(){for(var o=r.innerHeight,s=n.createTreeWalker(e.editor,NodeFilter.SHOW_ELEMENT,(function(){return NodeFilter.FILTER_ACCEPT}));s.nextNode();){var i=s.currentNode;if(o>i.getBoundingClientRect().top||a.scanFullPage){var u=t(i);if(u)for(var l=0;u.length>l;l++)c(u[l])}}}()}return r.prototype.generateCSS=function(){var e="";for(var t in this.css)if(!/:not\(/.test(t)){for(var r in e+=t+" { ",this.css[t])e+=r+": "+this.css[t][r]+"; ";e+="}\n"}return e},r}())(e.ew,e.ed,{scanFullPage:!0}).generateCSS()}},799:function(e){e.exports='<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path d="M19,21H5a2,2,0,0,1-2-2V17a1,1,0,0,1,2,0v2H19V17a1,1,0,0,1,2,0v2A2,2,0,0,1,19,21Z"/> <path d="M18,5H6A1,1,0,0,1,6,3H18a1,1,0,0,1,0,2Z"/> <path d="M15.71,10.29l-3-3a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-3,3a1,1,0,0,0-.21,1.09A1,1,0,0,0,9,12h2v3a1,1,0,0,0,2,0V12h2a1,1,0,0,0,.92-.62A1,1,0,0,0,15.71,10.29Z"/> </svg>'}},function(e){return e(e.s=797)}])}));