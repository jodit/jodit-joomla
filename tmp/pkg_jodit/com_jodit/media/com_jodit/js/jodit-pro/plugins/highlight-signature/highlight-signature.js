"use strict";((e,t)=>{if("object"==typeof exports&&"object"==typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var r=t();for(var i in r)("object"==typeof exports?exports:e)[i]=r[i]}})(self,(function(){return(self.webpackChunkjodit_pro=self.webpackChunkjodit_pro||[]).push([[10],{241(e,t,r){r.r(t),r.d(t,{highlightSignature:()=>c});var i=r(187),o=r(62),s=r(19),n=r(17),a=r(11),l=r(1);r(2).D.prototype.highlightSignature={schema:{},excludeTags:["pre"]};class c extends o.S{constructor(){super(...arguments),this.requires=["license"],this.idleId=0}afterInit(e){Object.keys(e.o.highlightSignature.schema).length&&e.e.on("change afterSetMode",this.walkNodes).on("afterGetValueFromEditor",c.removeUtilWrappers)}beforeDestruct(e){e.e.off("change afterSetMode",this.walkNodes).off("afterGetValueFromEditor",c.removeUtilWrappers)}walkNodes(){if(!this.j.isEditorMode())return;this.checkUtilsBoxToSchema();const{j:e}=this,t=e.ed.createNodeIterator(e.editor,NodeFilter.SHOW_TEXT);this.j.async.cancelIdleCallback(this.idleId),this.workLoop(t)}runWorker(e,t){let r;this.j.e.mute();try{do{if(r=t.nextNode(),!r)return;if(this.checkNormalizing(r))return;this.checkReplaceSchemas(r)}while(r&&e.timeRemaining()>1)}finally{this.j.e.unmute()}this.workLoop(t)}workLoop(e){this.idleId=this.j.async.requestIdleCallback((t=>{this.runWorker(t,e)}))}checkNormalizing(e){return!!n.i.isText(e.nextSibling)&&(this.j.editor.normalize(),this.walkNodes(),!0)}checkReplaceSchemas(e){if(c.hasUtilWrapper(e))return;const t=e.nodeValue;if(null==t)return;const{j:r}=this,i=r.o.highlightSignature;for(const r in i.schema){const o=RegExp(r);if(o.test(t)){const s=t.match(o);if(!s||void 0===s.index)continue;const a=i.schema[r](this.j,s);if(a)return n.i.markTemporary(a,{dataHighlightSchema:r}),void this.replaceMatchedTextToElm(e,t,s,a)}}}replaceMatchedTextToElm(e,t,r,i){var o;const{j:s}=this,{range:a}=s.s,l=a.startContainer===e,c=a.startOffset,h=null!==(o=r.index)&&void 0!==o?o:0;e.nodeValue=t.substr(0,h);const d=t.substr(h+r[0].length);if(d.length){const t=s.createInside.text(d);n.i.after(e,t)}i.innerText=r[0],n.i.after(e,i),l&&this.restoreCursorPosition(c,e,i.firstChild,i.nextSibling)}static hasUtilWrapper(e){return n.i.isTemporary(e.parentElement)}static removeUtilWrappers(e){e.value=n.i.replaceTemporaryFromString(e.value)}restoreCursorPosition(e,...t){for(const r of t)if(r&&r.nodeValue){const t=r.nodeValue;if(t.length>=e){const t=this.j.s.createRange();t.setStart(r,e),this.j.s.selectRange(t,!1);break}e-=t.length}}checkUtilsBoxToSchema(){n.i.temporaryList(this.j.editor).forEach((e=>{var t;const r=(0,a.Lj)(e,"dataHighlightSchema");if(!r)return;const i=RegExp(r),o=null!==(t=e.innerText)&&void 0!==t?t:"";i.test(o)&&!o.replace(i,"").length||(this.j.s.save(),n.i.unwrap(e),this.j.s.restore())}))}}(0,i.gn)([(0,s.debounce)()],c.prototype,"walkNodes",null),(0,i.gn)([s.autobind],c.prototype,"runWorker",null),l.Jodit.plugins.add("highlight-signature",c)},187(e,t,r){function i(e,t,r,i){var o,s=arguments.length,n=3>s?t:null===i?i=Object.getOwnPropertyDescriptor(t,r):i;if("object"==typeof Reflect&&"function"==typeof Reflect.decorate)n=Reflect.decorate(e,t,r,i);else for(var a=e.length-1;a>=0;a--)(o=e[a])&&(n=(3>s?o(n):s>3?o(t,r,n):o(t,r))||n);return s>3&&n&&Object.defineProperty(t,r,n),n}r.d(t,{gn:()=>i})}},e=>e(e.s=241)])}));