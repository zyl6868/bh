webpackJsonp([8],{456:function(e,t,n){function s(e){n(513)}var a=n(115)(n(498),n(527),s,"data-v-1a6ec464",null);e.exports=a.exports},460:function(e,t,n){t=e.exports=n(449)(!1),t.push([e.i,".mint-toast{position:fixed;max-width:80%;border-radius:5px;background:rgba(0,0,0,.7);color:#fff;box-sizing:border-box;text-align:center;z-index:1000;-webkit-transition:opacity .3s linear;transition:opacity .3s linear}.mint-toast.is-placebottom{bottom:50px;left:50%;-webkit-transform:translate(-50%);transform:translate(-50%)}.mint-toast.is-placemiddle{left:50%;top:50%;-webkit-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.mint-toast.is-placetop{top:50px;left:50%;-webkit-transform:translate(-50%);transform:translate(-50%)}.mint-toast-icon{display:block;text-align:center;font-size:56px}.mint-toast-text{font-size:14px;display:block;text-align:center}.mint-toast-pop-enter,.mint-toast-pop-leave-active{opacity:0}",""])},461:function(e,t,n){var s=n(460);"string"==typeof s&&(s=[[e.i,s,""]]),s.locals&&(e.exports=s.locals);n(450)("f8edb9fa",s,!0)},462:function(e,t,n){e.exports=function(e){function t(s){if(n[s])return n[s].exports;var a=n[s]={i:s,l:!1,exports:{}};return e[s].call(a.exports,a,a.exports,t),a.l=!0,a.exports}var n={};return t.m=e,t.c=n,t.i=function(e){return e},t.d=function(e,n,s){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:s})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=242)}({0:function(e,t){e.exports=function(e,t,n,s,a){var r,i=e=e||{},o=typeof e.default;"object"!==o&&"function"!==o||(r=e,i=e.default);var c="function"==typeof i?i.options:i;t&&(c.render=t.render,c.staticRenderFns=t.staticRenderFns),s&&(c._scopeId=s);var l;if(a?(l=function(e){e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,e||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),n&&n.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(a)},c._ssrRegister=l):n&&(l=n),l){var u=c.functional,p=u?c.render:c.beforeCreate;u?c.render=function(e,t){return l.call(t),p(e,t)}:c.beforeCreate=p?[].concat(p,l):[l]}return{esModule:r,exports:i,options:c}}},1:function(e,t){e.exports=n(57)},101:function(e,t){},164:function(e,t,n){function s(e){n(101)}var a=n(0)(n(86),n(170),s,null,null);e.exports=a.exports},170:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("transition",{attrs:{name:"mint-toast-pop"}},[n("div",{directives:[{name:"show",rawName:"v-show",value:e.visible,expression:"visible"}],staticClass:"mint-toast",class:e.customClass,style:{padding:""===e.iconClass?"10px":"20px"}},[""!==e.iconClass?n("i",{staticClass:"mint-toast-icon",class:e.iconClass}):e._e(),e._v(" "),n("span",{staticClass:"mint-toast-text",style:{"padding-top":""===e.iconClass?"0":"10px"}},[e._v(e._s(e.message))])])])},staticRenderFns:[]}},242:function(e,t,n){e.exports=n(50)},50:function(e,t,n){"use strict";var s=n(94);Object.defineProperty(t,"__esModule",{value:!0}),n.d(t,"default",function(){return s.a})},86:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={props:{message:String,className:{type:String,default:""},position:{type:String,default:"middle"},iconClass:{type:String,default:""}},data:function(){return{visible:!1}},computed:{customClass:function(){var e=[];switch(this.position){case"top":e.push("is-placetop");break;case"bottom":e.push("is-placebottom");break;default:e.push("is-placemiddle")}return e.push(this.className),e.join(" ")}}}},94:function(e,t,n){"use strict";var s=n(1),a=n.n(s),r=a.a.extend(n(164)),i=[],o=function(){if(i.length>0){var e=i[0];return i.splice(0,1),e}return new r({el:document.createElement("div")})},c=function(e){e&&i.push(e)},l=function(e){e.target.parentNode&&e.target.parentNode.removeChild(e.target)};r.prototype.close=function(){this.visible=!1,this.$el.addEventListener("transitionend",l),this.closed=!0,c(this)};var u=function(e){void 0===e&&(e={});var t=e.duration||3e3,n=o();return n.closed=!1,clearTimeout(n.timer),n.message="string"==typeof e?e:e.message,n.position=e.position||"middle",n.className=e.className||"",n.iconClass=e.iconClass||"",document.body.appendChild(n.$el),a.a.nextTick(function(){n.visible=!0,n.$el.removeEventListener("transitionend",l),~t&&(n.timer=setTimeout(function(){n.closed||n.close()},t))}),n};t.a=u}})},473:function(e,t,n){e.exports={default:n(474),__esModule:!0}},474:function(e,t,n){var s=n(45),a=s.JSON||(s.JSON={stringify:JSON.stringify});e.exports=function(e){return a.stringify.apply(a,arguments)}},498:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var s=n(461),a=(n.n(s),n(462)),r=n.n(a),i=n(473),o=n.n(i);t.default={data:function(){return{}},created:function(){},methods:{scan:function(){var e={};e.url=this.$route.params.url.toString(),e.materialId=this.$route.params.id.toString(),e.type=0,BHWEB.resourceScan&&"function"==typeof BHWEB.resourceScan?BHWEB.resourceScan(o()(e)):r()({message:"暂未开放，敬请期待",position:"middle",duration:2e3})}}}},504:function(e,t,n){t=e.exports=n(449)(!1),t.push([e.i,"[data-v-1a6ec464]{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.wraper[data-v-1a6ec464]{height:100%}.shareScreen[data-v-1a6ec464]{width:100%;text-align:center;color:#2a51ed}.shareScreen p[data-v-1a6ec464]{font-size:14px}.shareScreen .scanShow[data-v-1a6ec464]{width:100%}.shareScreen .shareTitle[data-v-1a6ec464]{font-size:14px;color:#555;margin:1rem 0 .266667rem}.shareScreen .scan[data-v-1a6ec464]{margin:0 auto;width:2rem}.shareScreen .scan img[data-v-1a6ec464]{width:.773333rem}@media screen and (max-width:320px){.header .title p[data-v-1a6ec464]{margin-top:-.133333rem}}",""])},513:function(e,t,n){var s=n(504);"string"==typeof s&&(s=[[e.i,s,""]]),s.locals&&(e.exports=s.locals);n(450)("2234e729",s,!0)},523:function(e,t){e.exports="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADoAAAA6CAMAAADWZboaAAAAilBMVEUAAAAqUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0qUe0U13AvAAAALXRSTlMAyPH3FG0608PeSo5qR8zr5Zh4cCWuhX11YEI+MxsG16eTUk29uZ6KbmRZvCrnvMPgAAABUUlEQVRIx+2Xa0+DMBSGD+KowLjDuA3GRXdT/v/fk56JrbJpThNjtuz5QEjePCVNd5a3gNSHxHyQ0WL45M39Em2SvBbhwRu+o4mUzUI/n7JgmGMK1TsTt5dN3RFqpw9zbJ5Y+Pq0cAxBWYFEVUqRFWko8LV9/rIEAnvc0cdHMyCRcqeAAFcgYuJun8fniqrao/QCLu6UyAJPnqmoS34mqC7IX72rN6xuxmdEVSOu4hCEVDUcJYZDsKaq69O4pdsCyBRBCFdKnGgEkgoE7kDiFQSMpjL5nEydgGmAzCMB+F/SrUOX+iYFtZ+/MUo7HLpMaegUR/06/9bu6p+r6jXEVVH3qCpVrhYrl1LR87HoOQr1csWdUqXUhlNNd36t0nHfWxNOl7koFKeaOUe3hNkNZ9gB0tKvDfYU5v5PlxV3vu5RpHXeMO/SFSnW5MRjzbEGzjs+I3O0kXUoMgAAAABJRU5ErkJggg=="},524:function(e,t,n){e.exports=n.p+"pub/v3Res/img/scanShow.abc1f49.png"},527:function(e,t,n){e.exports={render:function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"wrapper"},[s("div",{staticClass:"shareScreen"},[s("img",{staticClass:"scanShow",attrs:{src:n(524)}}),e._v(" "),s("p",{staticClass:"shareTitle"},[e._v("1.在电脑浏览器中访问以下地址")]),e._v(" "),s("p",[e._v("tp.banhai.com")]),e._v(" "),s("p",{staticClass:"shareTitle"},[e._v("2.扫描投屏二维码")]),e._v(" "),s("div",{staticClass:"scan",on:{click:e.scan}},[s("img",{attrs:{src:n(523)}}),e._v(" "),s("p",[e._v("扫一扫")])])])])},staticRenderFns:[]}}});