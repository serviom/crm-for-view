(self.webpackChunk=self.webpackChunk||[]).push([[4316,6357,4600,429,1152],{7757:(e,t,r)=>{e.exports=r(5666)},2266:(e,t,r)=>{"use strict";r.d(t,{Z:()=>o});var n=r(3645),i=r.n(n)()((function(e){return e[1]}));i.push([e.id,".page-controls.position-fixed[data-v-24c9b4a5]{right:24px;top:14px;z-index:5}",""]);const o=i},7582:(e,t,r)=>{"use strict";r.d(t,{Z:()=>o});var n=r(3645),i=r.n(n)()((function(e){return e[1]}));i.push([e.id,".v-btn[data-v-6b826798]{min-width:150px!important}",""]);const o=i},7997:(e,t,r)=>{"use strict";r.d(t,{Z:()=>o});var n=r(3645),i=r.n(n)()((function(e){return e[1]}));i.push([e.id,".v-btn[data-v-41a38cd0]{min-width:150px!important}.v-btn.w-auto[data-v-41a38cd0]{min-width:auto!important}",""]);const o=i},5666:e=>{var t=function(e){"use strict";var t,r=Object.prototype,n=r.hasOwnProperty,i="function"==typeof Symbol?Symbol:{},o=i.iterator||"@@iterator",s=i.asyncIterator||"@@asyncIterator",a=i.toStringTag||"@@toStringTag";function u(e,t,r){return Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}),e[t]}try{u({},"")}catch(e){u=function(e,t,r){return e[t]=r}}function c(e,t,r,n){var i=t&&t.prototype instanceof m?t:m,o=Object.create(i.prototype),s=new C(n||[]);return o._invoke=function(e,t,r){var n=f;return function(i,o){if(n===h)throw new Error("Generator is already running");if(n===p){if("throw"===i)throw o;return N()}for(r.method=i,r.arg=o;;){var s=r.delegate;if(s){var a=P(s,r);if(a){if(a===v)continue;return a}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===f)throw n=p,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=h;var u=l(e,t,r);if("normal"===u.type){if(n=r.done?p:d,u.arg===v)continue;return{value:u.arg,done:r.done}}"throw"===u.type&&(n=p,r.method="throw",r.arg=u.arg)}}}(e,r,s),o}function l(e,t,r){try{return{type:"normal",arg:e.call(t,r)}}catch(e){return{type:"throw",arg:e}}}e.wrap=c;var f="suspendedStart",d="suspendedYield",h="executing",p="completed",v={};function m(){}function b(){}function y(){}var g={};u(g,o,(function(){return this}));var w=Object.getPrototypeOf,_=w&&w(w(E([])));_&&_!==r&&n.call(_,o)&&(g=_);var x=y.prototype=m.prototype=Object.create(g);function S(e){["next","throw","return"].forEach((function(t){u(e,t,(function(e){return this._invoke(t,e)}))}))}function O(e,t){function r(i,o,s,a){var u=l(e[i],e,o);if("throw"!==u.type){var c=u.arg,f=c.value;return f&&"object"==typeof f&&n.call(f,"__await")?t.resolve(f.__await).then((function(e){r("next",e,s,a)}),(function(e){r("throw",e,s,a)})):t.resolve(f).then((function(e){c.value=e,s(c)}),(function(e){return r("throw",e,s,a)}))}a(u.arg)}var i;this._invoke=function(e,n){function o(){return new t((function(t,i){r(e,n,t,i)}))}return i=i?i.then(o,o):o()}}function P(e,r){var n=e.iterator[r.method];if(n===t){if(r.delegate=null,"throw"===r.method){if(e.iterator.return&&(r.method="return",r.arg=t,P(e,r),"throw"===r.method))return v;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return v}var i=l(n,e.iterator,r.arg);if("throw"===i.type)return r.method="throw",r.arg=i.arg,r.delegate=null,v;var o=i.arg;return o?o.done?(r[e.resultName]=o.value,r.next=e.nextLoc,"return"!==r.method&&(r.method="next",r.arg=t),r.delegate=null,v):o:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,v)}function j(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function $(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function C(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(j,this),this.reset(!0)}function E(e){if(e){var r=e[o];if(r)return r.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var i=-1,s=function r(){for(;++i<e.length;)if(n.call(e,i))return r.value=e[i],r.done=!1,r;return r.value=t,r.done=!0,r};return s.next=s}}return{next:N}}function N(){return{value:t,done:!0}}return b.prototype=y,u(x,"constructor",y),u(y,"constructor",b),b.displayName=u(y,a,"GeneratorFunction"),e.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===b||"GeneratorFunction"===(t.displayName||t.name))},e.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,y):(e.__proto__=y,u(e,a,"GeneratorFunction")),e.prototype=Object.create(x),e},e.awrap=function(e){return{__await:e}},S(O.prototype),u(O.prototype,s,(function(){return this})),e.AsyncIterator=O,e.async=function(t,r,n,i,o){void 0===o&&(o=Promise);var s=new O(c(t,r,n,i),o);return e.isGeneratorFunction(r)?s:s.next().then((function(e){return e.done?e.value:s.next()}))},S(x),u(x,a,"Generator"),u(x,o,(function(){return this})),u(x,"toString",(function(){return"[object Generator]"})),e.keys=function(e){var t=[];for(var r in e)t.push(r);return t.reverse(),function r(){for(;t.length;){var n=t.pop();if(n in e)return r.value=n,r.done=!1,r}return r.done=!0,r}},e.values=E,C.prototype={constructor:C,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=t,this.done=!1,this.delegate=null,this.method="next",this.arg=t,this.tryEntries.forEach($),!e)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=t)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var r=this;function i(n,i){return a.type="throw",a.arg=e,r.next=n,i&&(r.method="next",r.arg=t),!!i}for(var o=this.tryEntries.length-1;o>=0;--o){var s=this.tryEntries[o],a=s.completion;if("root"===s.tryLoc)return i("end");if(s.tryLoc<=this.prev){var u=n.call(s,"catchLoc"),c=n.call(s,"finallyLoc");if(u&&c){if(this.prev<s.catchLoc)return i(s.catchLoc,!0);if(this.prev<s.finallyLoc)return i(s.finallyLoc)}else if(u){if(this.prev<s.catchLoc)return i(s.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<s.finallyLoc)return i(s.finallyLoc)}}}},abrupt:function(e,t){for(var r=this.tryEntries.length-1;r>=0;--r){var i=this.tryEntries[r];if(i.tryLoc<=this.prev&&n.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var o=i;break}}o&&("break"===e||"continue"===e)&&o.tryLoc<=t&&t<=o.finallyLoc&&(o=null);var s=o?o.completion:{};return s.type=e,s.arg=t,o?(this.method="next",this.next=o.finallyLoc,v):this.complete(s)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),v},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.finallyLoc===e)return this.complete(r.completion,r.afterLoc),$(r),v}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.tryLoc===e){var n=r.completion;if("throw"===n.type){var i=n.arg;$(r)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(e,r,n){return this.delegate={iterator:E(e),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=t),v}},e}(e.exports);try{regeneratorRuntime=t}catch(e){"object"==typeof globalThis?globalThis.regeneratorRuntime=t:Function("r","regeneratorRuntime = r")(t)}},6357:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>i});const n={props:["editMode","title","isShowSpinner","link","create","edit"],components:{CrmDefaultFormsControls:r(4600).default}};const i=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("form",[r("v-container",{attrs:{fluid:""}},[r("v-row",[r("v-col",{attrs:{cols:"12",sm:"6"}},[r("div",{staticClass:"h2"},[e._v(e._s(e.title))])]),e._v(" "),r("v-col",{attrs:{cols:"12",sm:"6"}},[r("crm-default-forms-controls",{attrs:{editMode:e.editMode,isShowSpinner:e.isShowSpinner,link:e.link,create:e.create,edit:e.edit,isScrollable:!0}})],1),e._v(" "),r("v-col",{attrs:{cols:"12",sm:"12"}},[e._t("default")],2),e._v(" "),r("v-col",{attrs:{cols:"12",sm:"12"}},[r("crm-default-forms-controls",{attrs:{editMode:e.editMode,isShowSpinner:e.isShowSpinner,link:e.link,create:e.create,edit:e.edit,isScrollable:!1}})],1)],1)],1)],1)}),[],!1,null,"738a3ecd",null).exports},4600:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>f});function n(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function i(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?n(Object(r),!0).forEach((function(t){o(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):n(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function o(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const s={props:["editMode","isShowSpinner","link","create","edit","isScrollable"],data:function(){return{isPositionFixed:!1,isMobile:!1}},beforeDestroy:function(){"undefined"!=typeof window&&window.removeEventListener("resize",this.onResize,{passive:!0})},mounted:function(){this.onResize(),window.addEventListener("resize",this.onResize,{passive:!0})},methods:i(i({},(0,r(629).nv)({setIsShowUserWidget:"NavBarModule/setIsShowUserWidget"})),{},{onResize:function(){"undefined"!=typeof window&&this.isScrollable&&(window.innerWidth<960?(this.isMobile=!0,this.setIsShowUserWidget(!0)):(this.isMobile=!1,this.setIsShowUserWidget(!this.isPositionFixed)))},onScroll:function(e){"undefined"!=typeof window&&this.isScrollable&&((window.pageYOffset||e.target.scrollTop||0)>50?(this.isPositionFixed=!0,this.setIsShowUserWidget(this.isMobile)):(this.isPositionFixed=!1,this.setIsShowUserWidget(!0)))}})};var a=r(3379),u=r.n(a),c=r(2266),l={insert:"head",singleton:!1};u()(c.Z,l);c.Z.locals;const f=(0,r(1900).Z)(s,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{directives:[{name:"scroll",rawName:"v-scroll",value:e.onScroll,expression:"onScroll"}],staticClass:"page-controls",class:[e.isPositionFixed?"position-fixed":"",e.isScrollable?"d-none d-md-flex justify-end":"d-flex d-md-none justify-center"]},[e.editMode?e._e():r("v-btn",{staticClass:"mr-4",attrs:{disabled:e.isShowSpinner,color:"primary"},on:{click:e.create}},[e.isShowSpinner?r("span",[r("v-progress-circular",{attrs:{size:25,indeterminate:"",color:"grey"}})],1):r("span",[e._v("Створити")])]),e._v(" "),e.editMode?r("v-btn",{staticClass:"mr-4",attrs:{disabled:e.isShowSpinner,color:"primary"},on:{click:e.edit}},[e.isShowSpinner?r("span",[r("v-progress-circular",{attrs:{size:25,indeterminate:"",color:"grey"}})],1):r("span",[e._v("Редагувати")])]):e._e(),e._v(" "),r("router-link",{attrs:{to:e.link}},[r("v-btn",{attrs:{color:"secondary"}},[e._v("\n            Скасувати\n        ")])],1)],1)}),[],!1,null,"24c9b4a5",null).exports},429:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>u});const n={props:["maxWidth","color","isShowDialog","isShowSpinner","isAction","isCancelBtn","actionBtnText","defaultBtnText","cancelBtnText"],data:function(){return{isShow:!1}},watch:{isShowDialog:function(e){this.isShow=e},isShow:function(e){e||this.$emit("closeDialog")}},methods:{successEvent:function(){this.$emit("successEvent")},closeDialog:function(){this.$emit("closeDialog")}}};var i=r(3379),o=r.n(i),s=r(7582),a={insert:"head",singleton:!1};o()(s.Z,a);s.Z.locals;const u=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("v-dialog",{attrs:{transition:"dialog-bottom-transition","max-width":e.maxWidth||600},scopedSlots:e._u([{key:"default",fn:function(t){return[r("v-card",{staticClass:"pa-0 pb-6"},[r("v-toolbar",{staticClass:"text-h4",attrs:{color:e.color,dark:""}},[e._t("info-title")],2),e._v(" "),r("v-card-text",[r("div",{staticClass:"pt-5"},[e._t("info-text")],2)]),e._v(" "),r("v-card-actions",{staticClass:"justify-center"},[e.isAction?r("v-btn",{staticClass:"text-white mr-4",attrs:{disabled:e.isShowSpinner,color:e.color},on:{click:e.successEvent}},[e.isShowSpinner?r("span",[r("v-progress-circular",{attrs:{size:25,indeterminate:"",color:"grey"}})],1):r("span",[e._v(e._s(e.actionBtnText))])]):r("v-btn",{staticClass:"text-white mr-4",attrs:{color:e.color},on:{click:e.successEvent}},[r("span",[e._v(e._s(e.defaultBtnText))])]),e._v(" "),null===e.isCancelBtn||e.isCancelBtn?r("v-btn",{on:{click:e.closeDialog}},[e._v("\n                    "+e._s(e.cancelBtnText||"Скасувати")+"\n                ")]):e._e()],1)],1)]}}],null,!0),model:{value:e.isShow,callback:function(t){e.isShow=t},expression:"isShow"}})}),[],!1,null,"6b826798",null).exports},1152:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>b});var n=r(8620),i=r(379),o=r(6486),s=r(629),a=r(6357),u=r(429);function c(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function l(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?c(Object(r),!0).forEach((function(t){f(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):c(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function f(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const d={mixins:[n.oE],props:["editMode","responseErrors","title"],components:{CrmDefaultFormPage:a.default,CrmDialog:u.default},validations:function(){return this.editMode,{client:{fio:{required:i.C1,maxLength:(0,i.BS)(100)},email:{maxLength:(0,i.BS)(100),email:i.Do},description:{maxLength:(0,i.BS)(1e3)},user_id:{},phoneNumbers:{required:i.C1,maxLength:(0,i.Ei)(1),$each:{phoneNumber:{required:i.C1,maxLength:(0,i.BS)(100),isUnique:function(e){return(0,o.filter)(this.client.phoneNumbers,{phoneNumber:e}).length<2}}}}}}},data:function(){return{isShowSpinner:!1,isShowValidationDialog:!1,responseData:{}}},computed:l(l({},(0,s.Se)({getClient:"ClientsModule/getClient",getAllUsersList:"ClientsModule/getAllUsers"})),{},{client:{get:function(){return this.getClient},set:function(e){this.setClient(e)}},fioErrors:function(){var e=[];return this.$v.client.fio.$dirty?(!this.$v.client.fio.maxLength&&e.push("Максимальна довжина 100 символів"),!this.$v.client.fio.required&&e.push("Поле ФІО обов'язкове"),e):e},emailErrors:function(){var e=[];return this.$v.client.email.$dirty?(!this.$v.client.email.maxLength&&e.push("Максимальна довжина 100 символів"),!this.$v.client.email.email&&e.push("Введіть валідний email"),e):e},descriptionErrors:function(){var e=[];return this.$v.client.description.$dirty?(!this.$v.client.description.maxLength&&e.push("Максимальна довжина 1000 символів"),e):e}}),mounted:function(){var e=this;this.$nextTick((function(){e.$refs.fio.focus()})),this.eventHub.$on("doShowClientValidationDialog",(function(t){e.responseData=t,e.showValidationDialog()}))},beforeDestroy:function(){this.eventHub.$off("doShowClientValidationDialog")},methods:l(l({},(0,s.nv)({setClient:"ClientsModule/setClient"})),{},{phoneNumbersErrors:function(e){var t=[];return this.$v.client.phoneNumbers.$each[e].$dirty?(!this.$v.client.phoneNumbers.$each[e].phoneNumber.maxLength&&t.push("Максимальна довжина 100 символів"),!this.$v.client.phoneNumbers.$each[e].phoneNumber.required&&t.push("Поле телефон обов'язкове"),!this.$v.client.phoneNumbers.$each[e].phoneNumber.isUnique&&t.push("Поле телефон містить значення, яке дублюється"),this.responseErrors["phoneNumbers."+e+".phoneNumber"]&&(t=t.concat(this.responseErrors["phoneNumbers."+e+".phoneNumber"])),t):t},addPhoneNumber:function(e){var t=this;this.client.phoneNumbers.push({phoneNumber:""}),this.$nextTick((function(){t.$refs["phone"+(e+1)][0].focus()}))},deletePhoneNumber:function(e){this.client.phoneNumbers.splice(e,1)},create:function(){this.$v.$touch(),this.$v.$invalid||this.$emit("create")},edit:function(){this.$v.$touch(),this.$v.$invalid||this.$emit("edit")},showValidationDialog:function(){this.isShowValidationDialog=!0},closeValidationDialog:function(){this.isShowValidationDialog=!1}})};var h=r(3379),p=r.n(h),v=r(7997),m={insert:"head",singleton:!1};p()(v.Z,m);v.Z.locals;const b=(0,r(1900).Z)(d,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("crm-default-form-page",{attrs:{editMode:e.editMode,title:e.title,isShowSpinner:e.isShowSpinner,link:{name:"clients"},create:e.create,edit:e.edit}},[r("v-row",[r("v-col",{attrs:{cols:"12",sm:"6"}},[r("v-text-field",{ref:"fio",attrs:{"error-messages":e.fioErrors,counter:100,label:"ФІО"},on:{input:function(t){return e.$v.client.fio.$touch()},blur:function(t){return e.$v.client.fio.$touch()}},model:{value:e.client.fio,callback:function(t){e.$set(e.client,"fio",t)},expression:"client.fio"}}),e._v(" "),r("v-autocomplete",{attrs:{items:e.getAllUsersList,clearable:!0,"item-text":"name","item-value":"id",label:"Користувач"},model:{value:e.client.user_id,callback:function(t){e.$set(e.client,"user_id",t)},expression:"client.user_id"}}),e._v(" "),r("v-textarea",{attrs:{"error-messages":e.descriptionErrors,counter:1e3,label:"Опис"},on:{input:function(t){return e.$v.client.description.$touch()},blur:function(t){return e.$v.client.description.$touch()}},model:{value:e.client.description,callback:function(t){e.$set(e.client,"description",t)},expression:"client.description"}})],1),e._v(" "),r("v-col",{attrs:{cols:"12",sm:"6"}},[r("v-text-field",{attrs:{"error-messages":e.emailErrors,label:"Email",counter:100},on:{input:function(t){return e.$v.client.email.$touch()},blur:function(t){return e.$v.client.email.$touch()}},model:{value:e.client.email,callback:function(t){e.$set(e.client,"email",t)},expression:"client.email"}}),e._v(" "),e._l(e.client.phoneNumbers,(function(t,n){return r("div",{key:n,staticClass:"d-flex align-items-center"},[r("v-text-field",{directives:[{name:"mask",rawName:"v-mask",value:"+## (###) ###-####",expression:"'+## (###) ###-####'"}],ref:"phone"+n,refInFor:!0,staticClass:"flex-grow-1 mr-3",attrs:{"error-messages":e.phoneNumbersErrors(n),label:"Телефон"},on:{input:function(t){return e.$v.client.phoneNumbers.$each[n].$touch()},blur:function(t){return e.$v.client.phoneNumbers.$each[n].$touch()}},model:{value:t.phoneNumber,callback:function(r){e.$set(t,"phoneNumber",r)},expression:"phoneNumber.phoneNumber"}}),e._v(" "),0===n?r("v-btn",{staticClass:"flex-grow-0 w-auto",attrs:{color:"success"},on:{click:function(t){return t.stopPropagation(),e.addPhoneNumber(n)}}},[r("v-icon",[e._v("mdi-plus")])],1):r("v-btn",{staticClass:"flex-grow-0 w-auto",attrs:{color:"light"},on:{click:function(t){return t.stopPropagation(),e.deletePhoneNumber(n)}}},[r("v-icon",[e._v("mdi-close-thick")])],1)],1)}))],2),e._v(" "),r("crm-dialog",{attrs:{isShowDialog:e.isShowValidationDialog,isAction:!1,isCancelBtn:!1,color:"warning",defaultBtnText:"Закрити"},on:{successEvent:e.closeValidationDialog,closeDialog:e.closeValidationDialog},scopedSlots:e._u([{key:"info-title",fn:function(){return[e._v("\n                Увага!\n            ")]},proxy:!0},{key:"info-text",fn:function(){return[e.responseData.phoneNumber_unique_user?r("div",[e._v("\n                    Клієнт\n                    "),r("router-link",{attrs:{to:{name:"clients.update",params:{id:e.responseData.phoneNumber_unique_client.id}}}},[r("b",[e._v(e._s(e.responseData.phoneNumber_unique_client.fio))])]),e._v("\n                    з номером телефону\n                    "),r("b",[e._v(e._s(e.responseData.phoneNumber_unique_phoneNumber))]),e._v("\n                    закріплений за користувачем\n                    "),r("router-link",{attrs:{to:{name:"users.update",params:{id:e.responseData.phoneNumber_unique_user.id}}}},[r("b",[e._v(e._s(e.responseData.phoneNumber_unique_user.name))])])],1):r("div",[e._v("\n                    Клієнт\n                    "),r("router-link",{attrs:{to:{name:"clients.update",params:{id:e.responseData.phoneNumber_unique_client.id}}}},[r("b",[e._v(e._s(e.responseData.phoneNumber_unique_client.fio))])]),e._v("\n                    з номером телефону\n                    "),r("b",[e._v(e._s(e.responseData.phoneNumber_unique_phoneNumber))]),e._v("\n                    вже існує\n                ")],1)]},proxy:!0}])})],1)],1)}),[],!1,null,"41a38cd0",null).exports},4316:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>p});var n=r(7757),i=r.n(n),o=r(1152),s=r(629),a=r(836),u=r(6486);function c(e,t,r,n,i,o,s){try{var a=e[o](s),u=a.value}catch(e){return void r(e)}a.done?t(u):Promise.resolve(u).then(n,i)}function l(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function f(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?l(Object(r),!0).forEach((function(t){d(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):l(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function d(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const h={components:{ClientsFormTemplate:o.default},data:function(){return{clientId:null,responseErrors:{}}},computed:f({},(0,s.Se)({getClientModel:"ClientsModule/getClient"})),created:function(){var e,t=this;return(e=i().mark((function e(){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.setClient((0,u.cloneDeep)(a.Z));case 2:case"end":return e.stop()}}),e)})),function(){var t=this,r=arguments;return new Promise((function(n,i){var o=e.apply(t,r);function s(e){c(o,n,i,s,a,"next",e)}function a(e){c(o,n,i,s,a,"throw",e)}s(void 0)}))})()},mounted:function(){this.clientId=this.$route.params.id,this.getClient(),this.getUsers()},methods:f(f({},(0,s.nv)({setClient:"ClientsModule/setClient",setAllUsers:"ClientsModule/setAllUsers",incrementSpinnerCounter:"SpinnerModule/incrementSpinnerCounter",decrementSpinnerCounter:"SpinnerModule/decrementSpinnerCounter"})),{},{getUsers:function(){var e=this;this.incrementSpinnerCounter(),this.axios.get("clients/all-users").then((function(t){e.setAllUsers(t.data.data)})).catch((function(e){})).then((function(){e.decrementSpinnerCounter()}))},getClient:function(){var e=this;this.incrementSpinnerCounter(),this.axios.get("clients/".concat(this.clientId)).then((function(t){e.setClient(t.data.data)})).catch((function(e){})).then((function(){e.decrementSpinnerCounter()}))},edit:function(){var e=this;this.incrementSpinnerCounter(),this.axios.put("clients/".concat(this.clientId),{fio:this.getClientModel.fio,email:this.getClientModel.email,description:this.getClientModel.description,user_id:this.getClientModel.user_id,phoneNumbers:this.getClientModel.phoneNumbers}).then((function(t){var r=t.data.message;e.eventHub.$emit("doShowSnackbarEvent",!0,r,"success",5e3),e.$router.push({name:"clients"}).catch((function(){}))})).catch((function(t){422===t.status&&(e.responseErrors=t.data.errors,t.data.phoneNumber_unique_failed&&e.eventHub.$emit("doShowClientValidationDialog",t.data))})).then((function(){e.decrementSpinnerCounter()}))}})};const p=(0,r(1900).Z)(h,(function(){var e=this,t=e.$createElement;return(e._self._c||t)("clients-form-template",{attrs:{"edit-mode":!0,responseErrors:e.responseErrors,title:"Редагувати клієнта"},on:{edit:e.edit}})}),[],!1,null,"dcf8481a",null).exports},6408:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("alpha",/^[a-zA-Z]*$/);t.default=n},6195:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("alphaNum",/^[a-zA-Z0-9]*$/);t.default=n},5573:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++)t[r]=arguments[r];return(0,n.withParams)({type:"and"},(function(){for(var e=this,r=arguments.length,n=new Array(r),i=0;i<r;i++)n[i]=arguments[i];return t.length>0&&t.reduce((function(t,r){return t&&r.apply(e,n)}),!0)}))}},7884:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e,t){return(0,n.withParams)({type:"between",min:e,max:t},(function(r){return!(0,n.req)(r)||(!/\s/.test(r)||r instanceof Date)&&+e<=+r&&+t>=+r}))}},6681:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),Object.defineProperty(t,"withParams",{enumerable:!0,get:function(){return i.default}}),t.regex=t.ref=t.len=t.req=void 0;var n,i=(n=r(8085))&&n.__esModule?n:{default:n};function o(e){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},o(e)}var s=function(e){if(Array.isArray(e))return!!e.length;if(null==e)return!1;if(!1===e)return!0;if(e instanceof Date)return!isNaN(e.getTime());if("object"===o(e)){for(var t in e)return!0;return!1}return!!String(e).length};t.req=s;t.len=function(e){return Array.isArray(e)?e.length:"object"===o(e)?Object.keys(e).length:String(e).length};t.ref=function(e,t,r){return"function"==typeof e?e.call(t,r):r[e]};t.regex=function(e,t){return(0,i.default)({type:e},(function(e){return!s(e)||t.test(e)}))}},4078:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("decimal",/^[-]?\d*(\.\d+)?$/);t.default=n},8107:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("email",/^(?:[A-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[A-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]{2,}(?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/);t.default=n},379:(e,t,r)=>{"use strict";Object.defineProperty(t,"Do",{enumerable:!0,get:function(){return a.default}}),Object.defineProperty(t,"BS",{enumerable:!0,get:function(){return l.default}}),Object.defineProperty(t,"Ei",{enumerable:!0,get:function(){return f.default}}),Object.defineProperty(t,"C1",{enumerable:!0,get:function(){return d.default}}),Object.defineProperty(t,"PW",{enumerable:!0,get:function(){return _.default}});var n=O(r(6408)),i=O(r(6195)),o=O(r(5669)),s=O(r(7884)),a=O(r(8107)),u=O(r(9103)),c=O(r(7340)),l=O(r(5287)),f=O(r(3091)),d=O(r(2419)),h=O(r(2941)),p=O(r(8300)),v=O(r(918)),m=O(r(3213)),b=O(r(5832)),y=O(r(5573)),g=O(r(2500)),w=O(r(2628)),_=O(r(301)),x=O(r(6673)),S=O(r(4078));function O(e){return e&&e.__esModule?e:{default:e}}(function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)if(Object.prototype.hasOwnProperty.call(e,r)){var n=Object.defineProperty&&Object.getOwnPropertyDescriptor?Object.getOwnPropertyDescriptor(e,r):{};n.get||n.set?Object.defineProperty(t,r,n):t[r]=e[r]}t.default=e})(r(6681))},6673:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("integer",/(^[0-9]*$)|(^-[0-9]+$)/);t.default=n},9103:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681),i=(0,n.withParams)({type:"ipAddress"},(function(e){if(!(0,n.req)(e))return!0;if("string"!=typeof e)return!1;var t=e.split(".");return 4===t.length&&t.every(o)}));t.default=i;var o=function(e){if(e.length>3||0===e.length)return!1;if("0"===e[0]&&"0"!==e)return!1;if(!e.match(/^\d+$/))return!1;var t=0|+e;return t>=0&&t<=255}},7340:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:":";return(0,n.withParams)({type:"macAddress"},(function(t){if(!(0,n.req)(t))return!0;if("string"!=typeof t)return!1;var r="string"==typeof e&&""!==e?t.split(e):12===t.length||16===t.length?t.match(/.{2}/g):null;return null!==r&&(6===r.length||8===r.length)&&r.every(i)}))};var i=function(e){return e.toLowerCase().match(/^[0-9a-f]{2}$/)}},5287:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"maxLength",max:e},(function(t){return!(0,n.req)(t)||(0,n.len)(t)<=e}))}},301:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"maxValue",max:e},(function(t){return!(0,n.req)(t)||(!/\s/.test(t)||t instanceof Date)&&+t<=+e}))}},3091:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"minLength",min:e},(function(t){return!(0,n.req)(t)||(0,n.len)(t)>=e}))}},2628:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"minValue",min:e},(function(t){return!(0,n.req)(t)||(!/\s/.test(t)||t instanceof Date)&&+t>=+e}))}},2500:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"not"},(function(t,r){return!(0,n.req)(t)||!e.call(this,t,r)}))}},5669:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("numeric",/^[0-9]*$/);t.default=n},5832:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++)t[r]=arguments[r];return(0,n.withParams)({type:"or"},(function(){for(var e=this,r=arguments.length,n=new Array(r),i=0;i<r;i++)n[i]=arguments[i];return t.length>0&&t.reduce((function(t,r){return t||r.apply(e,n)}),!1)}))}},2419:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681),i=(0,n.withParams)({type:"required"},(function(e){return"string"==typeof e?(0,n.req)(e.trim()):(0,n.req)(e)}));t.default=i},2941:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"requiredIf",prop:e},(function(t,r){return!(0,n.ref)(e,this,r)||(0,n.req)(t)}))}},8300:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"requiredUnless",prop:e},(function(t,r){return!!(0,n.ref)(e,this,r)||(0,n.req)(t)}))}},918:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"sameAs",eq:e},(function(t,r){return t===(0,n.ref)(e,this,r)}))}},3213:(e,t,r)=>{"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("url",/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i);t.default=n},8085:(e,t,r)=>{"use strict";var n=r(4155);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var i="web"===n.env.BUILD?r(16).R:r(8413).withParams;t.default=i},16:(e,t,r)=>{"use strict";function n(e){return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}t.R=void 0;var i="undefined"!=typeof window?window:void 0!==r.g?r.g:{},o=i.vuelidate?i.vuelidate.withParams:function(e,t){return"object"===n(e)&&void 0!==t?t:e((function(){}))};t.R=o}}]);