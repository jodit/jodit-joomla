((e,t)=>{if("object"==typeof exports&&"object"==typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var r=t();for(var i in r)("object"==typeof exports?exports:e)[i]=r[i]}})(self,(function(){return(self.webpackChunkjodit_pro=self.webpackChunkjodit_pro||[]).push([[652],{221(e){"undefined"!=typeof self&&self,e.exports=(e=>{var t={};function r(i){if(t[i])return t[i].exports;var o=t[i]={i,l:!1,exports:{}};return e[i].call(o.exports,o,o.exports,r),o.l=!0,o.exports}return r.m=e,r.c=t,r.d=(e,t,i)=>{r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:i})},r.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=(e,t)=>{if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var i=Object.create(null);if(r.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(i,o,(t=>e[t]).bind(null,o));return i},r.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return r.d(t,"a",t),t},r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),r.p="",r(r.s=1)})([(e,t,r)=>{"use strict";var i=r(3);function o(e){return!0===i(e)&&"[object Object]"===Object.prototype.toString.call(e)}e.exports=e=>{var t,r;return!1!==o(e)&&"function"==typeof(t=e.constructor)&&!1!==o(r=t.prototype)&&!1!==r.hasOwnProperty("isPrototypeOf")}},function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.VERSION=t.PALETTE_MATERIAL_CHROME=t.PALETTE_MATERIAL_500=t.COLOR_NAMES=t.getLuminance=t.intToRgb=t.rgbToInt=t.rgbToHsv=t.rgbToHsl=t.hslToRgb=t.rgbToHex=t.parseColor=t.parseColorToHsla=t.parseColorToHsl=t.parseColorToRgba=t.parseColorToRgb=t.from=t.createPicker=void 0;var i=(()=>{function e(e,t){for(var r=0;t.length>r;r++){var i=t[r];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return(t,r,i)=>(r&&e(t.prototype,r),i&&e(t,i),t)})(),o=(e,t)=>{if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return((e,t)=>{var r=[],i=!0,o=!1,s=void 0;try{for(var a,n=e[Symbol.iterator]();!(i=(a=n.next()).done)&&(r.push(a.value),!t||r.length!==t);i=!0);}catch(e){o=!0,s=e}finally{try{!i&&n.return&&n.return()}finally{if(o)throw s}}return r})(e,t);throw new TypeError("Invalid attempt to destructure non-iterable instance")},s=r(2),a=l(r(0)),n=l(r(4));function l(e){return e&&e.__esModule?e:{default:e}}function h(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function c(e){if(Array.isArray(e)){for(var t=0,r=Array(e.length);e.length>t;t++)r[t]=e[t];return r}return Array.from(e)}var p="undefined"!=typeof window&&window.navigator.userAgent.indexOf("Edge")>-1,u="undefined"!=typeof window&&window.navigator.userAgent.indexOf("rv:")>-1,d={id:null,attachTo:"body",showHSL:!0,showRGB:!0,showHEX:!0,showAlpha:!1,color:"#ff0000",palette:null,paletteEditable:!1,useAlphaInPalette:"auto",slBarSize:[232,150],hueBarSize:[150,11],alphaBarSize:[150,11]},g="COLOR",b="RGBA_USER",v="HSLA_USER";function f(e,t,r){return e?e instanceof HTMLElement?e:e instanceof NodeList?e[0]:"string"==typeof e?document.querySelector(e):e.jquery?e.get(0):r?t:null:t}function m(e){var t=e.getContext("2d"),r=+e.width,i=+e.height,a=t.createLinearGradient(1,1,1,i-1);return a.addColorStop(0,"white"),a.addColorStop(1,"black"),{setHue(e){var o=t.createLinearGradient(1,0,r-1,0);o.addColorStop(0,"hsla("+e+", 100%, 50%, 0)"),o.addColorStop(1,"hsla("+e+", 100%, 50%, 1)"),t.fillStyle=a,t.fillRect(0,0,r,i),t.fillStyle=o,t.globalCompositeOperation="multiply",t.fillRect(0,0,r,i),t.globalCompositeOperation="source-over"},grabColor:(e,r)=>t.getImageData(e,r,1,1).data,findColor(e,t,a){var n=(0,s.rgbToHsv)(e,t,a),l=o(n,3);return[l[1]*r,i-l[2]*i]}}}function y(e,t,r){return null===e?t:/^\s*$/.test(e)?r:!!/true|yes|1/i.test(e)||!/false|no|0/i.test(e)&&t}function A(e,t,r){if(null===e)return t;if(/^\s*$/.test(e))return r;var i=e.split(",").map(Number);return 2===i.length&&i[0]&&i[1]?i:t}var k=function(){function e(t,r){if(h(this,e),r?(t=f(t),this.options=Object.assign({},d,r)):t&&(0,a.default)(t)?(this.options=Object.assign({},d,t),t=f(this.options.attachTo)):(this.options=Object.assign({},d),t=f((0,s.nvl)(t,this.options.attachTo))),!t)throw Error("Container not found: "+this.options.attachTo);!function(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"acp-";if(t.hasAttribute(r+"show-hsl")&&(e.showHSL=y(t.getAttribute(r+"show-hsl"),d.showHSL,!0)),t.hasAttribute(r+"show-rgb")&&(e.showRGB=y(t.getAttribute(r+"show-rgb"),d.showRGB,!0)),t.hasAttribute(r+"show-hex")&&(e.showHEX=y(t.getAttribute(r+"show-hex"),d.showHEX,!0)),t.hasAttribute(r+"show-alpha")&&(e.showAlpha=y(t.getAttribute(r+"show-alpha"),d.showAlpha,!0)),t.hasAttribute(r+"palette-editable")&&(e.paletteEditable=y(t.getAttribute(r+"palette-editable"),d.paletteEditable,!0)),t.hasAttribute(r+"sl-bar-size")&&(e.slBarSize=A(t.getAttribute(r+"sl-bar-size"),d.slBarSize,[232,150])),t.hasAttribute(r+"hue-bar-size")&&(e.hueBarSize=A(t.getAttribute(r+"hue-bar-size"),d.hueBarSize,[150,11]),e.alphaBarSize=e.hueBarSize),t.hasAttribute(r+"palette")){var i=t.getAttribute(r+"palette");switch(i){case"PALETTE_MATERIAL_500":e.palette=s.PALETTE_MATERIAL_500;break;case"PALETTE_MATERIAL_CHROME":case"":e.palette=s.PALETTE_MATERIAL_CHROME;break;default:e.palette=i.split(/[;|]/)}}t.hasAttribute(r+"color")&&(e.color=t.getAttribute(r+"color"))}(this.options,t),this.H=0,this.S=0,this.L=0,this.R=0,this.G=0,this.B=0,this.A=1,this.palette={},this.element=document.createElement("div"),this.options.id&&(this.element.id=this.options.id),this.element.className="a-color-picker",this.element.innerHTML=n.default,t.appendChild(this.element);var i=this.element.querySelector(".a-color-picker-h");this.setupHueCanvas(i),this.hueBarHelper=m(i),this.huePointer=this.element.querySelector(".a-color-picker-h+.a-color-picker-dot");var o=this.element.querySelector(".a-color-picker-sl");this.setupSlCanvas(o),this.slBarHelper=m(o),this.slPointer=this.element.querySelector(".a-color-picker-sl+.a-color-picker-dot"),this.preview=this.element.querySelector(".a-color-picker-preview"),this.setupClipboard(this.preview.querySelector(".a-color-picker-clipbaord")),this.options.showHSL?(this.setupInput(this.inputH=this.element.querySelector(".a-color-picker-hsl>input[nameref=H]")),this.setupInput(this.inputS=this.element.querySelector(".a-color-picker-hsl>input[nameref=S]")),this.setupInput(this.inputL=this.element.querySelector(".a-color-picker-hsl>input[nameref=L]"))):this.element.querySelector(".a-color-picker-hsl").remove(),this.options.showRGB?(this.setupInput(this.inputR=this.element.querySelector(".a-color-picker-rgb>input[nameref=R]")),this.setupInput(this.inputG=this.element.querySelector(".a-color-picker-rgb>input[nameref=G]")),this.setupInput(this.inputB=this.element.querySelector(".a-color-picker-rgb>input[nameref=B]"))):this.element.querySelector(".a-color-picker-rgb").remove(),this.options.showHEX?this.setupInput(this.inputRGBHEX=this.element.querySelector("input[nameref=RGBHEX]")):this.element.querySelector(".a-color-picker-rgbhex").remove(),this.options.paletteEditable||this.options.palette&&this.options.palette.length>0?this.setPalette(this.paletteRow=this.element.querySelector(".a-color-picker-palette")):(this.paletteRow=this.element.querySelector(".a-color-picker-palette"),this.paletteRow.remove()),this.options.showAlpha?(this.setupAlphaCanvas(this.element.querySelector(".a-color-picker-a")),this.alphaPointer=this.element.querySelector(".a-color-picker-a+.a-color-picker-dot")):this.element.querySelector(".a-color-picker-alpha").remove(),this.element.style.width=this.options.slBarSize[0]+"px",this.onValueChanged(g,this.options.color)}return i(e,[{key:"setupHueCanvas",value(e){var t=this;e.width=this.options.hueBarSize[0],e.height=this.options.hueBarSize[1];for(var r=e.getContext("2d"),i=r.createLinearGradient(0,0,this.options.hueBarSize[0],0),o=0;1>=o;o+=1/360)i.addColorStop(o,"hsl("+360*o+", 100%, 50%)");r.fillStyle=i,r.fillRect(0,0,this.options.hueBarSize[0],this.options.hueBarSize[1]);var a=r=>{var i=(0,s.limit)(r.clientX-e.getBoundingClientRect().left,0,t.options.hueBarSize[0]),o=Math.round(360*i/t.options.hueBarSize[0]);t.huePointer.style.left=i-7+"px",t.onValueChanged("H",o)},n=function e(){document.removeEventListener("mousemove",a),document.removeEventListener("mouseup",e)};e.addEventListener("mousedown",(e=>{a(e),document.addEventListener("mousemove",a),document.addEventListener("mouseup",n)}))}},{key:"setupSlCanvas",value(e){var t=this;e.width=this.options.slBarSize[0],e.height=this.options.slBarSize[1];var r=r=>{var i=(0,s.limit)(r.clientX-e.getBoundingClientRect().left,0,t.options.slBarSize[0]-1),o=(0,s.limit)(r.clientY-e.getBoundingClientRect().top,0,t.options.slBarSize[1]-1),a=t.slBarHelper.grabColor(i,o);t.slPointer.style.left=i-7+"px",t.slPointer.style.top=o-7+"px",t.onValueChanged("RGB",a)},i=function e(){document.removeEventListener("mousemove",r),document.removeEventListener("mouseup",e)};e.addEventListener("mousedown",(e=>{r(e),document.addEventListener("mousemove",r),document.addEventListener("mouseup",i)}))}},{key:"setupAlphaCanvas",value(e){var t=this;e.width=this.options.alphaBarSize[0],e.height=this.options.alphaBarSize[1];var r=e.getContext("2d"),i=r.createLinearGradient(0,0,e.width-1,0);i.addColorStop(0,"hsla(0, 0%, 50%, 0)"),i.addColorStop(1,"hsla(0, 0%, 50%, 1)"),r.fillStyle=i,r.fillRect(0,0,this.options.alphaBarSize[0],this.options.alphaBarSize[1]);var o=r=>{var i=(0,s.limit)(r.clientX-e.getBoundingClientRect().left,0,t.options.alphaBarSize[0]),o=+(i/t.options.alphaBarSize[0]).toFixed(2);t.alphaPointer.style.left=i-7+"px",t.onValueChanged("ALPHA",o)},a=function e(){document.removeEventListener("mousemove",o),document.removeEventListener("mouseup",e)};e.addEventListener("mousedown",(e=>{o(e),document.addEventListener("mousemove",o),document.addEventListener("mouseup",a)}))}},{key:"setupInput",value(e){var t=this,r=+e.min,i=+e.max,o=e.getAttribute("nameref");e.hasAttribute("select-on-focus")&&e.addEventListener("focus",(()=>{e.select()})),"text"===e.type?e.addEventListener("change",(()=>{t.onValueChanged(o,e.value)})):((p||u)&&e.addEventListener("keydown",(a=>{"Up"===a.key?(e.value=(0,s.limit)(+e.value+1,r,i),t.onValueChanged(o,e.value),a.returnValue=!1):"Down"===a.key&&(e.value=(0,s.limit)(+e.value-1,r,i),t.onValueChanged(o,e.value),a.returnValue=!1)})),e.addEventListener("change",(()=>{t.onValueChanged(o,(0,s.limit)(+e.value,r,i))})))}},{key:"setupClipboard",value(e){var t=this;e.title="click to copy",e.addEventListener("click",(()=>{e.value=(0,s.parseColor)([t.R,t.G,t.B,t.A],"hexcss4"),e.select(),document.execCommand("copy")}))}},{key:"setPalette",value(e){var t=this,r="auto"===this.options.useAlphaInPalette?this.options.showAlpha:this.options.useAlphaInPalette,i=null;switch(this.options.palette){case"PALETTE_MATERIAL_500":i=s.PALETTE_MATERIAL_500;break;case"PALETTE_MATERIAL_CHROME":i=s.PALETTE_MATERIAL_CHROME;break;default:i=(0,s.ensureArray)(this.options.palette)}if(this.options.paletteEditable||i.length>0){var o=(r,i,o)=>{var s=e.querySelector('.a-color-picker-palette-color[data-color="'+r+'"]')||document.createElement("div");s.className="a-color-picker-palette-color",s.style.backgroundColor=r,s.setAttribute("data-color",r),s.title=r,e.insertBefore(s,i),t.palette[r]=!0,o&&t.onPaletteColorAdd(r)},a=(r,i)=>{r?(e.removeChild(r),t.palette[r.getAttribute("data-color")]=!1,i&&t.onPaletteColorRemove(r.getAttribute("data-color"))):(e.querySelectorAll(".a-color-picker-palette-color[data-color]").forEach((t=>{e.removeChild(t)})),Object.keys(t.palette).forEach((e=>{t.palette[e]=!1})),i&&t.onPaletteColorRemove())};if(i.map((e=>(0,s.parseColor)(e,r?"rgbcss4":"hex"))).filter((e=>!!e)).forEach((e=>o(e))),this.options.paletteEditable){var n=document.createElement("div");n.className="a-color-picker-palette-color a-color-picker-palette-add",n.innerHTML="+",e.appendChild(n),e.addEventListener("click",(e=>{/a-color-picker-palette-add/.test(e.target.className)?e.shiftKey?a(null,!0):o(r?(0,s.parseColor)([t.R,t.G,t.B,t.A],"rgbcss4"):(0,s.rgbToHex)(t.R,t.G,t.B),e.target,!0):/a-color-picker-palette-color/.test(e.target.className)&&(e.shiftKey?a(e.target,!0):t.onValueChanged(g,e.target.getAttribute("data-color")))}))}else e.addEventListener("click",(e=>{/a-color-picker-palette-color/.test(e.target.className)&&t.onValueChanged(g,e.target.getAttribute("data-color"))}))}else e.style.display="none"}},{key:"updatePalette",value(e){this.paletteRow.innerHTML="",this.palette={},this.paletteRow.parentElement||this.element.appendChild(this.paletteRow),this.options.palette=e,this.setPalette(this.paletteRow)}},{key:"onValueChanged",value(e,t){var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{silent:!1};switch(e){case"H":this.H=t;var i=(0,s.hslToRgb)(this.H,this.S,this.L),a=o(i,3);this.R=a[0],this.G=a[1],this.B=a[2],this.slBarHelper.setHue(t),this.updatePointerH(this.H),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGB(this.R,this.G,this.B),this.updateInputRGBHEX(this.R,this.G,this.B);break;case"S":this.S=t;var n=(0,s.hslToRgb)(this.H,this.S,this.L),l=o(n,3);this.R=l[0],this.G=l[1],this.B=l[2],this.updatePointerSL(this.H,this.S,this.L),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGB(this.R,this.G,this.B),this.updateInputRGBHEX(this.R,this.G,this.B);break;case"L":this.L=t;var h=(0,s.hslToRgb)(this.H,this.S,this.L),c=o(h,3);this.R=c[0],this.G=c[1],this.B=c[2],this.updatePointerSL(this.H,this.S,this.L),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGB(this.R,this.G,this.B),this.updateInputRGBHEX(this.R,this.G,this.B);break;case"R":this.R=t;var p=(0,s.rgbToHsl)(this.R,this.G,this.B),u=o(p,3);this.H=u[0],this.S=u[1],this.L=u[2],this.slBarHelper.setHue(this.H),this.updatePointerH(this.H),this.updatePointerSL(this.H,this.S,this.L),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGBHEX(this.R,this.G,this.B);break;case"G":this.G=t;var d=(0,s.rgbToHsl)(this.R,this.G,this.B),f=o(d,3);this.H=f[0],this.S=f[1],this.L=f[2],this.slBarHelper.setHue(this.H),this.updatePointerH(this.H),this.updatePointerSL(this.H,this.S,this.L),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGBHEX(this.R,this.G,this.B);break;case"B":this.B=t;var m=(0,s.rgbToHsl)(this.R,this.G,this.B),y=o(m,3);this.H=y[0],this.S=y[1],this.L=y[2],this.slBarHelper.setHue(this.H),this.updatePointerH(this.H),this.updatePointerSL(this.H,this.S,this.L),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGBHEX(this.R,this.G,this.B);break;case"RGB":var A=o(t,3);this.R=A[0],this.G=A[1],this.B=A[2];var k=(0,s.rgbToHsl)(this.R,this.G,this.B),F=o(k,3);this.H=F[0],this.S=F[1],this.L=F[2],this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGB(this.R,this.G,this.B),this.updateInputRGBHEX(this.R,this.G,this.B);break;case b:var E=o(t,4);this.R=E[0],this.G=E[1],this.B=E[2],this.A=E[3];var C=(0,s.rgbToHsl)(this.R,this.G,this.B),H=o(C,3);this.H=H[0],this.S=H[1],this.L=H[2],this.slBarHelper.setHue(this.H),this.updatePointerH(this.H),this.updatePointerSL(this.H,this.S,this.L),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGB(this.R,this.G,this.B),this.updateInputRGBHEX(this.R,this.G,this.B),this.updatePointerA(this.A);break;case v:var B=o(t,4);this.H=B[0],this.S=B[1],this.L=B[2],this.A=B[3];var R=(0,s.hslToRgb)(this.H,this.S,this.L),S=o(R,3);this.R=S[0],this.G=S[1],this.B=S[2],this.slBarHelper.setHue(this.H),this.updatePointerH(this.H),this.updatePointerSL(this.H,this.S,this.L),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGB(this.R,this.G,this.B),this.updateInputRGBHEX(this.R,this.G,this.B),this.updatePointerA(this.A);break;case"RGBHEX":var w=(0,s.cssColorToRgb)(t)||[this.R,this.G,this.B],L=o(w,3);this.R=L[0],this.G=L[1],this.B=L[2];var x=(0,s.rgbToHsl)(this.R,this.G,this.B),T=o(x,3);this.H=T[0],this.S=T[1],this.L=T[2],this.slBarHelper.setHue(this.H),this.updatePointerH(this.H),this.updatePointerSL(this.H,this.S,this.L),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGB(this.R,this.G,this.B);break;case g:var I=(0,s.parseColor)(t,"rgba")||[0,0,0,1],G=o(I,4);this.R=G[0],this.G=G[1],this.B=G[2],this.A=G[3];var P=(0,s.rgbToHsl)(this.R,this.G,this.B),D=o(P,3);this.H=D[0],this.S=D[1],this.L=D[2],this.slBarHelper.setHue(this.H),this.updatePointerH(this.H),this.updatePointerSL(this.H,this.S,this.L),this.updateInputHSL(this.H,this.S,this.L),this.updateInputRGB(this.R,this.G,this.B),this.updateInputRGBHEX(this.R,this.G,this.B),this.updatePointerA(this.A);break;case"ALPHA":this.A=t}this.preview.style.backgroundColor=1===this.A?"rgb("+this.R+","+this.G+","+this.B+")":"rgba("+this.R+","+this.G+","+this.B+","+this.A+")",r&&r.silent||this.onchange&&this.onchange(this.preview.style.backgroundColor)}},{key:"onPaletteColorAdd",value(e){this.oncoloradd&&this.oncoloradd(e)}},{key:"onPaletteColorRemove",value(e){this.oncolorremove&&this.oncolorremove(e)}},{key:"updateInputHSL",value(e,t,r){this.options.showHSL&&(this.inputH.value=e,this.inputS.value=t,this.inputL.value=r)}},{key:"updateInputRGB",value(e,t,r){this.options.showRGB&&(this.inputR.value=e,this.inputG.value=t,this.inputB.value=r)}},{key:"updateInputRGBHEX",value(e,t,r){this.options.showHEX&&(this.inputRGBHEX.value=(0,s.rgbToHex)(e,t,r))}},{key:"updatePointerH",value(e){this.huePointer.style.left=this.options.hueBarSize[0]*e/360-7+"px"}},{key:"updatePointerSL",value(e,t,r){var i=(0,s.hslToRgb)(e,t,r),a=o(i,3),n=this.slBarHelper.findColor(a[0],a[1],a[2]),l=o(n,2),h=l[0],c=l[1];h>=0&&(this.slPointer.style.left=h-7+"px",this.slPointer.style.top=c-7+"px")}},{key:"updatePointerA",value(e){this.options.showAlpha&&(this.alphaPointer.style.left=this.options.alphaBarSize[0]*e-7+"px")}}]),e}(),F=function(){function e(t){h(this,e),this.name=t,this.listeners=[]}return i(e,[{key:"on",value(e){e&&this.listeners.push(e)}},{key:"off",value(e){this.listeners=e?this.listeners.filter((t=>t!==e)):[]}},{key:"emit",value(e,t){for(var r=this.listeners.slice(0),i=0;r.length>i;i++)r[i].apply(t,e)}}]),e}();function E(e,t){var r=new k(e,t),i={change:new F("change"),coloradd:new F("coloradd"),colorremove:new F("colorremove")},a=!0,n={},l={get element(){return r.element},get rgb(){return[r.R,r.G,r.B]},set rgb(e){var t=o(e,3),i=t[0],a=t[1],n=t[2],l=[(0,s.limit)(i,0,255),(0,s.limit)(a,0,255),(0,s.limit)(n,0,255)];r.onValueChanged(b,[i=l[0],a=l[1],n=l[2],1])},get hsl(){return[r.H,r.S,r.L]},set hsl(e){var t=o(e,3),i=t[0],a=t[1],n=t[2],l=[(0,s.limit)(i,0,360),(0,s.limit)(a,0,100),(0,s.limit)(n,0,100)];r.onValueChanged(v,[i=l[0],a=l[1],n=l[2],1])},get rgbhex(){return this.all.hex},get rgba(){return[r.R,r.G,r.B,r.A]},set rgba(e){var t=o(e,4),i=t[0],a=t[1],n=t[2],l=t[3],h=[(0,s.limit)(i,0,255),(0,s.limit)(a,0,255),(0,s.limit)(n,0,255),(0,s.limit)(l,0,1)];r.onValueChanged(b,[i=h[0],a=h[1],n=h[2],l=h[3]])},get hsla(){return[r.H,r.S,r.L,r.A]},set hsla(e){var t=o(e,4),i=t[0],a=t[1],n=t[2],l=t[3],h=[(0,s.limit)(i,0,360),(0,s.limit)(a,0,100),(0,s.limit)(n,0,100),(0,s.limit)(l,0,1)];r.onValueChanged(v,[i=h[0],a=h[1],n=h[2],l=h[3]])},get color(){return""+this.all},set color(e){r.onValueChanged(g,e)},setColor(e){r.onValueChanged(g,e,{silent:arguments.length>1&&void 0!==arguments[1]&&arguments[1]})},get all(){if(a){var e=[r.R,r.G,r.B,r.A],t=1>r.A?"rgba("+r.R+","+r.G+","+r.B+","+r.A+")":s.rgbToHex.apply(void 0,e);(n=(0,s.parseColor)(e,n)).toString=()=>t,a=!1}return Object.assign({},n)},get onchange(){return i.change&&i.change.listeners[0]},set onchange(e){this.off("change").on("change",e)},get oncoloradd(){return i.coloradd&&i.coloradd.listeners[0]},set oncoloradd(e){this.off("coloradd").on("coloradd",e)},get oncolorremove(){return i.colorremove&&i.colorremove.listeners[0]},set oncolorremove(e){this.off("colorremove").on("colorremove",e)},get palette(){return Object.keys(r.palette).filter((e=>r.palette[e]))},set palette(e){r.updatePalette(e)},show(){r.element.classList.remove("hidden")},hide(){r.element.classList.add("hidden")},toggle(){r.element.classList.toggle("hidden")},on(e,t){return e&&i[e]&&i[e].on(t),this},off(e,t){return e&&i[e]&&i[e].off(t),this},destroy(){i.change.off(),i.coloradd.off(),i.colorremove.off(),r.element.remove(),i=null,r=null}};return r.onchange=function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];a=!0,i.change.emit([l].concat(t),l)},r.oncoloradd=function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];i.coloradd.emit([l].concat(t),l)},r.oncolorremove=function(){for(var e=arguments.length,t=Array(e),r=0;e>r;r++)t[r]=arguments[r];i.colorremove.emit([l].concat(t),l)},r.element.ctrl=l,l}if("undefined"!=typeof window&&!document.querySelector('head>style[data-source="a-color-picker"]')){var C=""+r(5),H=document.createElement("style");H.setAttribute("type","text/css"),H.setAttribute("data-source","a-color-picker"),H.innerHTML=C,document.querySelector("head").appendChild(H)}t.createPicker=E,t.from=function(e,t){var r=(e=>e?Array.isArray(e)?e:e instanceof HTMLElement?[e]:e instanceof NodeList?[].concat(c(e)):"string"==typeof e?[].concat(c(document.querySelectorAll(e))):e.jquery?e.get():[]:[])(e).map(((e,r)=>{var i=E(e,t);return i.index=r,i}));return r.on=function(e,t){return r.forEach((r=>r.on(e,t))),this},r.off=function(e){return r.forEach((t=>t.off(e))),this},r},t.parseColorToRgb=s.parseColorToRgb,t.parseColorToRgba=s.parseColorToRgba,t.parseColorToHsl=s.parseColorToHsl,t.parseColorToHsla=s.parseColorToHsla,t.parseColor=s.parseColor,t.rgbToHex=s.rgbToHex,t.hslToRgb=s.hslToRgb,t.rgbToHsl=s.rgbToHsl,t.rgbToHsv=s.rgbToHsv,t.rgbToInt=s.rgbToInt,t.intToRgb=s.intToRgb,t.getLuminance=s.getLuminance,t.COLOR_NAMES=s.COLOR_NAMES,t.PALETTE_MATERIAL_500=s.PALETTE_MATERIAL_500,t.PALETTE_MATERIAL_CHROME=s.PALETTE_MATERIAL_CHROME,t.VERSION="1.2.1"},(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.nvl=t.ensureArray=t.limit=t.getLuminance=t.parseColor=t.parseColorToHsla=t.parseColorToHsl=t.cssHslaToHsla=t.cssHslToHsl=t.parseColorToRgba=t.parseColorToRgb=t.cssRgbaToRgba=t.cssRgbToRgb=t.cssColorToRgba=t.cssColorToRgb=t.intToRgb=t.rgbToInt=t.rgbToHsv=t.rgbToHsl=t.hslToRgb=t.rgbToHex=t.PALETTE_MATERIAL_CHROME=t.PALETTE_MATERIAL_500=t.COLOR_NAMES=void 0;var i=(e,t)=>{if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return((e,t)=>{var r=[],i=!0,o=!1,s=void 0;try{for(var a,n=e[Symbol.iterator]();!(i=(a=n.next()).done)&&(r.push(a.value),!t||r.length!==t);i=!0);}catch(e){o=!0,s=e}finally{try{!i&&n.return&&n.return()}finally{if(o)throw s}}return r})(e,t);throw new TypeError("Invalid attempt to destructure non-iterable instance")},o=(e=>e&&e.__esModule?e:{default:e})(r(0));function s(e){if(Array.isArray(e)){for(var t=0,r=Array(e.length);e.length>t;t++)r[t]=e[t];return r}return Array.from(e)}var a={aliceblue:"#F0F8FF",antiquewhite:"#FAEBD7",aqua:"#00FFFF",aquamarine:"#7FFFD4",azure:"#F0FFFF",beige:"#F5F5DC",bisque:"#FFE4C4",black:"#000000",blanchedalmond:"#FFEBCD",blue:"#0000FF",blueviolet:"#8A2BE2",brown:"#A52A2A",burlywood:"#DEB887",cadetblue:"#5F9EA0",chartreuse:"#7FFF00",chocolate:"#D2691E",coral:"#FF7F50",cornflowerblue:"#6495ED",cornsilk:"#FFF8DC",crimson:"#DC143C",cyan:"#00FFFF",darkblue:"#00008B",darkcyan:"#008B8B",darkgoldenrod:"#B8860B",darkgray:"#A9A9A9",darkgrey:"#A9A9A9",darkgreen:"#006400",darkkhaki:"#BDB76B",darkmagenta:"#8B008B",darkolivegreen:"#556B2F",darkorange:"#FF8C00",darkorchid:"#9932CC",darkred:"#8B0000",darksalmon:"#E9967A",darkseagreen:"#8FBC8F",darkslateblue:"#483D8B",darkslategray:"#2F4F4F",darkslategrey:"#2F4F4F",darkturquoise:"#00CED1",darkviolet:"#9400D3",deeppink:"#FF1493",deepskyblue:"#00BFFF",dimgray:"#696969",dimgrey:"#696969",dodgerblue:"#1E90FF",firebrick:"#B22222",floralwhite:"#FFFAF0",forestgreen:"#228B22",fuchsia:"#FF00FF",gainsboro:"#DCDCDC",ghostwhite:"#F8F8FF",gold:"#FFD700",goldenrod:"#DAA520",gray:"#808080",grey:"#808080",green:"#008000",greenyellow:"#ADFF2F",honeydew:"#F0FFF0",hotpink:"#FF69B4","indianred ":"#CD5C5C","indigo ":"#4B0082",ivory:"#FFFFF0",khaki:"#F0E68C",lavender:"#E6E6FA",lavenderblush:"#FFF0F5",lawngreen:"#7CFC00",lemonchiffon:"#FFFACD",lightblue:"#ADD8E6",lightcoral:"#F08080",lightcyan:"#E0FFFF",lightgoldenrodyellow:"#FAFAD2",lightgray:"#D3D3D3",lightgrey:"#D3D3D3",lightgreen:"#90EE90",lightpink:"#FFB6C1",lightsalmon:"#FFA07A",lightseagreen:"#20B2AA",lightskyblue:"#87CEFA",lightslategray:"#778899",lightslategrey:"#778899",lightsteelblue:"#B0C4DE",lightyellow:"#FFFFE0",lime:"#00FF00",limegreen:"#32CD32",linen:"#FAF0E6",magenta:"#FF00FF",maroon:"#800000",mediumaquamarine:"#66CDAA",mediumblue:"#0000CD",mediumorchid:"#BA55D3",mediumpurple:"#9370DB",mediumseagreen:"#3CB371",mediumslateblue:"#7B68EE",mediumspringgreen:"#00FA9A",mediumturquoise:"#48D1CC",mediumvioletred:"#C71585",midnightblue:"#191970",mintcream:"#F5FFFA",mistyrose:"#FFE4E1",moccasin:"#FFE4B5",navajowhite:"#FFDEAD",navy:"#000080",oldlace:"#FDF5E6",olive:"#808000",olivedrab:"#6B8E23",orange:"#FFA500",orangered:"#FF4500",orchid:"#DA70D6",palegoldenrod:"#EEE8AA",palegreen:"#98FB98",paleturquoise:"#AFEEEE",palevioletred:"#DB7093",papayawhip:"#FFEFD5",peachpuff:"#FFDAB9",peru:"#CD853F",pink:"#FFC0CB",plum:"#DDA0DD",powderblue:"#B0E0E6",purple:"#800080",rebeccapurple:"#663399",red:"#FF0000",rosybrown:"#BC8F8F",royalblue:"#4169E1",saddlebrown:"#8B4513",salmon:"#FA8072",sandybrown:"#F4A460",seagreen:"#2E8B57",seashell:"#FFF5EE",sienna:"#A0522D",silver:"#C0C0C0",skyblue:"#87CEEB",slateblue:"#6A5ACD",slategray:"#708090",slategrey:"#708090",snow:"#FFFAFA",springgreen:"#00FF7F",steelblue:"#4682B4",tan:"#D2B48C",teal:"#008080",thistle:"#D8BFD8",tomato:"#FF6347",turquoise:"#40E0D0",violet:"#EE82EE",wheat:"#F5DEB3",white:"#FFFFFF",whitesmoke:"#F5F5F5",yellow:"#FFFF00",yellowgreen:"#9ACD32"};function n(e,t,r){return isNaN(e=+e)||t>e?t:e>r?r:e}function l(e,t){return null==e?t:e}function h(e,t,r){var i=[n(e,0,255),n(t,0,255),n(r,0,255)];return"#"+("000000"+((e=i[0])<<16|(t=i[1])<<8|(r=i[2])).toString(16)).slice(-6)}function c(e,t,r){var i=void 0,o=void 0,s=void 0,a=[n(e,0,360)/360,n(t,0,100)/100,n(r,0,100)/100];if(e=a[0],r=a[2],0==(t=a[1]))i=o=s=r;else{var l=(e,t,r)=>(0>r&&(r+=1),r>1&&(r-=1),1/6>r?e+6*(t-e)*r:.5>r?t:2/3>r?e+(t-e)*(2/3-r)*6:e),h=.5>r?r*(1+t):r+t-r*t,c=2*r-h;i=l(c,h,e+1/3),o=l(c,h,e),s=l(c,h,e-1/3)}return[255*i,255*o,255*s].map(Math.round)}function p(e,t,r){var i=[n(e,0,255)/255,n(t,0,255)/255,n(r,0,255)/255],o=Math.max(e=i[0],t=i[1],r=i[2]),s=Math.min(e,t,r),a=void 0,l=void 0,h=(o+s)/2;if(o==s)a=l=0;else{var c=o-s;switch(l=h>.5?c/(2-o-s):c/(o+s),o){case e:a=(t-r)/c+(r>t?6:0);break;case t:a=(r-e)/c+2;break;case r:a=(e-t)/c+4}a/=6}return[360*a,100*l,100*h].map(Math.round)}function u(e,t,r){return e<<16|t<<8|r}function d(e){if(e){var t=/^\s*#?((([0-9A-F])([0-9A-F])([0-9A-F]))|(([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})))\s*$/i.exec(a[(""+e).toLowerCase()]||e)||[],r=i(t,10),o=r[3],s=r[4],n=r[5],l=r[7],h=r[8],c=r[9];if(void 0!==o)return[parseInt(o+o,16),parseInt(s+s,16),parseInt(n+n,16)];if(void 0!==l)return[parseInt(l,16),parseInt(h,16),parseInt(c,16)]}}function g(e){if(e){var t=/^\s*#?((([0-9A-F])([0-9A-F])([0-9A-F])([0-9A-F])?)|(([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})?))\s*$/i.exec(a[(""+e).toLowerCase()]||e)||[],r=i(t,12),o=r[3],s=r[4],n=r[5],l=r[6],h=r[8],c=r[9],p=r[10],u=r[11];if(void 0!==o)return[parseInt(o+o,16),parseInt(s+s,16),parseInt(n+n,16),l?+(parseInt(l+l,16)/255).toFixed(2):1];if(void 0!==h)return[parseInt(h,16),parseInt(c,16),parseInt(p,16),u?+(parseInt(u,16)/255).toFixed(2):1]}}function b(e){if(e){var t=/^rgb\((\d+)[\s,](\d+)[\s,](\d+)\)/i.exec(e)||[],r=i(t,4),o=r[2],s=r[3];return r[0]?[n(r[1],0,255),n(o,0,255),n(s,0,255)]:void 0}}function v(e){if(e){var t=/^rgba?\((\d+)\s*[\s,]\s*(\d+)\s*[\s,]\s*(\d+)(\s*[\s,]\s*(\d*(.\d+)?))?\)/i.exec(e)||[],r=i(t,6),o=r[2],s=r[3],a=r[5];return r[0]?[n(r[1],0,255),n(o,0,255),n(s,0,255),n(l(a,1),0,1)]:void 0}}function f(e){if(Array.isArray(e))return[n(e[0],0,255),n(e[1],0,255),n(e[2],0,255),n(l(e[3],1),0,1)];var t=g(e)||v(e);return t&&3===t.length&&t.push(1),t}function m(e){if(e){var t=/^hsl\((\d+)[\s,](\d+)[\s,](\d+)\)/i.exec(e)||[],r=i(t,4),o=r[2],s=r[3];return r[0]?[n(r[1],0,360),n(o,0,100),n(s,0,100)]:void 0}}function y(e){if(e){var t=/^hsla?\((\d+)\s*[\s,]\s*(\d+)\s*[\s,]\s*(\d+)(\s*[\s,]\s*(\d*(.\d+)?))?\)/i.exec(e)||[],r=i(t,6),o=r[2],s=r[3],a=r[5];return r[0]?[n(r[1],0,255),n(o,0,255),n(s,0,255),n(l(a,1),0,1)]:void 0}}function A(e){if(Array.isArray(e))return[n(e[0],0,360),n(e[1],0,100),n(e[2],0,100),n(l(e[3],1),0,1)];var t=y(e);return t&&3===t.length&&t.push(1),t}function k(e,t){switch(t){case"rgb":default:return e.slice(0,3);case"rgbcss":return"rgb("+e[0]+", "+e[1]+", "+e[2]+")";case"rgbcss4":return"rgb("+e[0]+", "+e[1]+", "+e[2]+", "+e[3]+")";case"rgba":return e;case"rgbacss":return"rgba("+e[0]+", "+e[1]+", "+e[2]+", "+e[3]+")";case"hsl":return p.apply(void 0,s(e));case"hslcss":return"hsl("+(e=p.apply(void 0,s(e)))[0]+", "+e[1]+", "+e[2]+")";case"hslcss4":var r=p.apply(void 0,s(e));return"hsl("+r[0]+", "+r[1]+", "+r[2]+", "+e[3]+")";case"hsla":return[].concat(s(p.apply(void 0,s(e))),[e[3]]);case"hslacss":var i=p.apply(void 0,s(e));return"hsla("+i[0]+", "+i[1]+", "+i[2]+", "+e[3]+")";case"hex":return h.apply(void 0,s(e));case"hexcss4":return h.apply(void 0,s(e))+("00"+parseInt(255*e[3]).toString(16)).slice(-2);case"int":return u.apply(void 0,s(e))}}t.COLOR_NAMES=a,t.PALETTE_MATERIAL_500=["#F44336","#E91E63","#E91E63","#9C27B0","#9C27B0","#673AB7","#673AB7","#3F51B5","#3F51B5","#2196F3","#2196F3","#03A9F4","#03A9F4","#00BCD4","#00BCD4","#009688","#009688","#4CAF50","#4CAF50","#8BC34A","#8BC34A","#CDDC39","#CDDC39","#FFEB3B","#FFEB3B","#FFC107","#FFC107","#FF9800","#FF9800","#FF5722","#FF5722","#795548","#795548","#9E9E9E","#9E9E9E","#607D8B","#607D8B"],t.PALETTE_MATERIAL_CHROME=["#f44336","#e91e63","#9c27b0","#673ab7","#3f51b5","#2196f3","#03a9f4","#00bcd4","#009688","#4caf50","#8bc34a","#cddc39","#ffeb3b","#ffc107","#ff9800","#ff5722","#795548","#9e9e9e","#607d8b"],t.rgbToHex=h,t.hslToRgb=c,t.rgbToHsl=p,t.rgbToHsv=(e,t,r)=>{var i,o=[n(e,0,255)/255,n(t,0,255)/255,n(r,0,255)/255],s=Math.max(e=o[0],t=o[1],r=o[2]),a=Math.min(e,t,r),l=void 0,h=s,c=s-a;if(i=0===s?0:c/s,s==a)l=0;else{switch(s){case e:l=(t-r)/c+(r>t?6:0);break;case t:l=(r-e)/c+2;break;case r:l=(e-t)/c+4}l/=6}return[l,i,h]},t.rgbToInt=u,t.intToRgb=e=>[e>>16&255,e>>8&255,255&e],t.cssColorToRgb=d,t.cssColorToRgba=g,t.cssRgbToRgb=b,t.cssRgbaToRgba=v,t.parseColorToRgb=e=>Array.isArray(e)?e=[n(e[0],0,255),n(e[1],0,255),n(e[2],0,255)]:d(e)||b(e),t.parseColorToRgba=f,t.cssHslToHsl=m,t.cssHslaToHsla=y,t.parseColorToHsl=e=>Array.isArray(e)?e=[n(e[0],0,360),n(e[1],0,100),n(e[2],0,100)]:m(e),t.parseColorToHsla=A,t.parseColor=(e,t)=>{if(t=t||"rgb",null!=e){var r=void 0;if((r=f(e))||(r=A(e))&&(r=[].concat(s(c.apply(void 0,s(r))),[r[3]])))return(0,o.default)(t)?["rgb","rgbcss","rgbcss4","rgba","rgbacss","hsl","hslcss","hslcss4","hsla","hslacss","hex","hexcss4","int"].reduce(((e,t)=>(e[t]=k(r,t),e)),t||{}):k(r,(""+t).toLowerCase())}},t.getLuminance=(e,t,r)=>.2126*(e=.03928>(e/=255)?e/12.92:Math.pow((e+.055)/1.055,2.4))+.7152*(t=.03928>(t/=255)?t/12.92:Math.pow((t+.055)/1.055,2.4))+.0722*(.03928>(r/=255)?r/12.92:Math.pow((r+.055)/1.055,2.4)),t.limit=n,t.ensureArray=e=>e?Array.from(e):[],t.nvl=l},(e,t,r)=>{"use strict";e.exports=e=>null!=e&&"object"==typeof e&&!1===Array.isArray(e)},(e,t)=>{e.exports='<div class="a-color-picker-row a-color-picker-stack a-color-picker-row-top"> <canvas class="a-color-picker-sl a-color-picker-transparent"></canvas> <div class=a-color-picker-dot></div> </div> <div class=a-color-picker-row> <div class="a-color-picker-stack a-color-picker-transparent a-color-picker-circle"> <div class=a-color-picker-preview> <input class=a-color-picker-clipbaord type=text> </div> </div> <div class=a-color-picker-column> <div class="a-color-picker-cell a-color-picker-stack"> <canvas class=a-color-picker-h></canvas> <div class=a-color-picker-dot></div> </div> <div class="a-color-picker-cell a-color-picker-alpha a-color-picker-stack" show-on-alpha> <canvas class="a-color-picker-a a-color-picker-transparent"></canvas> <div class=a-color-picker-dot></div> </div> </div> </div> <div class="a-color-picker-row a-color-picker-hsl" show-on-hsl> <label>H</label> <input nameref=H type=number maxlength=3 min=0 max=360 value=0> <label>S</label> <input nameref=S type=number maxlength=3 min=0 max=100 value=0> <label>L</label> <input nameref=L type=number maxlength=3 min=0 max=100 value=0> </div> <div class="a-color-picker-row a-color-picker-rgb" show-on-rgb> <label>R</label> <input nameref=R type=number maxlength=3 min=0 max=255 value=0> <label>G</label> <input nameref=G type=number maxlength=3 min=0 max=255 value=0> <label>B</label> <input nameref=B type=number maxlength=3 min=0 max=255 value=0> </div> <div class="a-color-picker-row a-color-picker-rgbhex a-color-picker-single-input" show-on-single-input> <label>HEX</label> <input nameref=RGBHEX type=text select-on-focus> </div> <div class="a-color-picker-row a-color-picker-palette"></div>'},(e,t,r)=>{var i=r(6);e.exports="string"==typeof i?i:""+i},(e,t,r)=>{(e.exports=r(7)(!1)).push([e.i,"/*!\n * a-color-picker\n * https://github.com/narsenico/a-color-picker\n *\n * Copyright (c) 2017-2018, Gianfranco Caldi.\n * Released under the MIT License.\n */.a-color-picker{background-color:#fff;padding:0;display:inline-flex;flex-direction:column;user-select:none;width:232px;font:400 10px Helvetica,Arial,sans-serif;border-radius:3px;box-shadow:0 0 0 1px rgba(0,0,0,.05),0 2px 4px rgba(0,0,0,.25)}.a-color-picker,.a-color-picker-row,.a-color-picker input{box-sizing:border-box}.a-color-picker-row{padding:15px;display:flex;flex-direction:row;align-items:center;justify-content:space-between;user-select:none}.a-color-picker-row-top{padding:0}.a-color-picker-row:not(:first-child){border-top:1px solid #f5f5f5}.a-color-picker-column{display:flex;flex-direction:column}.a-color-picker-cell{flex:1 1 auto;margin-bottom:4px}.a-color-picker-cell:last-child{margin-bottom:0}.a-color-picker-stack{position:relative}.a-color-picker-dot{position:absolute;width:14px;height:14px;top:0;left:0;background:#fff;pointer-events:none;border-radius:50px;z-index:1000;box-shadow:0 1px 2px rgba(0,0,0,.75)}.a-color-picker-a,.a-color-picker-h,.a-color-picker-sl{cursor:cell}.a-color-picker-a+.a-color-picker-dot,.a-color-picker-h+.a-color-picker-dot{top:-2px}.a-color-picker-a,.a-color-picker-h{border-radius:2px}.a-color-picker-preview{box-sizing:border-box;width:30px;height:30px;user-select:none;border-radius:15px}.a-color-picker-circle{border-radius:50px;border:1px solid #eee}.a-color-picker-hsl,.a-color-picker-rgb,.a-color-picker-single-input{justify-content:space-evenly}.a-color-picker-hsl>label,.a-color-picker-rgb>label,.a-color-picker-single-input>label{padding:0 8px;flex:0 0 auto;color:#969696}.a-color-picker-hsl>input,.a-color-picker-rgb>input,.a-color-picker-single-input>input{text-align:center;padding:2px 0;width:0;flex:1 1 auto;border:1px solid #e0e0e0;line-height:20px}.a-color-picker-hsl>input::-webkit-inner-spin-button,.a-color-picker-rgb>input::-webkit-inner-spin-button,.a-color-picker-single-input>input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}.a-color-picker-hsl>input:focus,.a-color-picker-rgb>input:focus,.a-color-picker-single-input>input:focus{border-color:#04a9f4;outline:none}.a-color-picker-transparent{background-image:linear-gradient(-45deg,#cdcdcd 25%,transparent 0),linear-gradient(45deg,#cdcdcd 25%,transparent 0),linear-gradient(-45deg,transparent 75%,#cdcdcd 0),linear-gradient(45deg,transparent 75%,#cdcdcd 0);background-size:11px 11px;background-position:0 0,0 -5.5px,-5.5px 5.5px,5.5px 0}.a-color-picker-sl{border-radius:3px 3px 0 0}.a-color-picker.hide-alpha [show-on-alpha],.a-color-picker.hide-hsl [show-on-hsl],.a-color-picker.hide-rgb [show-on-rgb],.a-color-picker.hide-single-input [show-on-single-input]{display:none}.a-color-picker-clipbaord{width:100%;height:100%;opacity:0;cursor:pointer}.a-color-picker-palette{flex-flow:wrap;flex-direction:row;justify-content:flex-start;padding:10px}.a-color-picker-palette-color{width:15px;height:15px;flex:0 1 15px;margin:3px;box-sizing:border-box;cursor:pointer;border-radius:3px;box-shadow:inset 0 0 0 1px rgba(0,0,0,.1)}.a-color-picker-palette-add{text-align:center;line-height:13px;color:#607d8b}.a-color-picker.hidden{display:none}",""])},function(e,t){e.exports=function(e){var t=[];return t.toString=function(){return this.map((t=>{var r=((e,t)=>{var r=e[1]||"",i=e[3];if(!i)return r;if(t&&"function"==typeof btoa){var o=(e=>"/*# sourceMappingURL=data:application/json;charset=utf-8;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(e))))+" */")(i),s=i.sources.map((e=>"/*# sourceURL="+i.sourceRoot+e+" */"));return[r].concat(s).concat([o]).join("\n")}return""+r})(t,e);return t[2]?"@media "+t[2]+"{"+r+"}":r})).join("")},t.i=function(e,r){"string"==typeof e&&(e=[[null,e,""]]);for(var i={},o=0;this.length>o;o++){var s=this[o][0];"number"==typeof s&&(i[s]=!0)}for(o=0;e.length>o;o++){var a=e[o];"number"==typeof a[0]&&i[a[0]]||(r&&!a[2]?a[2]=r:r&&(a[2]="("+a[2]+") and ("+r+")"),t.push(a))}},t}}])},219(e,t,r){"use strict";r.r(t),r.d(t,{colorPicker:()=>h});var i=r(187),o=r(62),s=r(4),a=r(220),n=r(19),l=r(1);class h extends o.S{constructor(){super(...arguments),this.requires=["license"],this.hasStyle=!l.Jodit.fatMode}afterInit(e){e.e.on("afterGenerateColorPicker",this.onAfterGenerateColorPicker)}onAfterGenerateColorPicker(e,t,r,i){s.Dom.detach(t);const o=new a.T(this.j,{value:i||"#000",onChange:r});t.appendChild(o.container)}beforeDestruct(e){e.e.off("afterGenerateColorPicker",this.onAfterGenerateColorPicker)}}(0,i.gn)([n.autobind],h.prototype,"onAfterGenerateColorPicker",null),l.Jodit.plugins.add("color-picker",h)},220(e,t,r){"use strict";r.d(t,{T:()=>c});var i=r(187),o=r(37),s=r(19),a=r(10),n=r(221),l=r(4),h=r(3);let c=class extends o.u3{constructor(e,t){super(e,t);const r=new o.GI(e);this.popup=r,this.trigger=(0,o.zx)(this.j,"ok");const i=this.getElm("wrapper");(0,a.assert)(null!=i,"wrapper element does not exist"),i.appendChild(this.trigger.container),this.trigger.container.classList.add(this.getFullElName("trigger")),this.trigger.onAction((()=>{var e,t;null===(t=(e=this.state).onChange)||void 0===t||t.call(e,this.value),r.close()})),r.setMod("padding",!1).setMod("max-height",!1);const s=this.j.create.div(this.getFullElName("picker")),h=n.createPicker(s,{paletteEditable:!0,showAlpha:!0,palette:"PALETTE_MATERIAL_CHROME"}).on("change",((e,t)=>{this.isFocused||(this.value=n.parseColor(t||"","hex"))}));this.j.e.on(this,"change",(()=>{n.parseColor(this.value,"hex")!==h.color&&(h.color=this.value)})),r.setContent(s),this.j.e.on(this.nativeInput,"click",(()=>{r.parentElement=this,this.jodit instanceof l.Dialog&&r.setZIndex(this.jodit.getZIndex()+1),r.open((()=>(0,a.position)(this.container)))})),this.onChangeValue(),this.onChangeSelfValue()}className(){return"ColorInput"}setMod(e,t,r=this.container){return"slim"===e&&t&&this.nativeInput.setAttribute("readonly","true"),super.setMod(e,t,r)}onChangeSelfValue(){this.nativeInput.style.backgroundColor=this.value}onEscKeyDown(e){var t;e.key===h.KEY_ESC&&(null===(t=this.popup)||void 0===t||t.close())}};(0,i.gn)([(0,s.watch)(":change")],c.prototype,"onChangeSelfValue",null),(0,i.gn)([(0,s.watch)("nativeInput:keydown")],c.prototype,"onEscKeyDown",null),c=(0,i.gn)([s.component],c)},187(e,t,r){"use strict";function i(e,t,r,i){var o,s=arguments.length,a=3>s?t:null===i?i=Object.getOwnPropertyDescriptor(t,r):i;if("object"==typeof Reflect&&"function"==typeof Reflect.decorate)a=Reflect.decorate(e,t,r,i);else for(var n=e.length-1;n>=0;n--)(o=e[n])&&(a=(3>s?o(a):s>3?o(t,r,a):o(t,r))||a);return s>3&&a&&Object.defineProperty(t,r,a),a}r.d(t,{gn:()=>i})}},e=>e(e.s=219)])}));