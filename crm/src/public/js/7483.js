"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[7483,6357,4600],{2266:(e,t,r)=>{r.d(t,{Z:()=>i});var n=r(3645),o=r.n(n)()((function(e){return e[1]}));o.push([e.id,".page-controls.position-fixed[data-v-24c9b4a5]{right:24px;top:14px;z-index:5}",""]);const i=o},5367:(e,t,r)=>{r.d(t,{Z:()=>i});var n=r(3645),o=r.n(n)()((function(e){return e[1]}));o.push([e.id,".v-btn[data-v-4fc7290e]{min-width:150px!important}",""]);const i=o},6357:(e,t,r)=>{r.r(t),r.d(t,{default:()=>o});const n={props:["editMode","title","isShowSpinner","link","create","edit"],components:{CrmDefaultFormsControls:r(4600).default}};const o=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("form",[r("v-container",{attrs:{fluid:""}},[r("v-row",[r("v-col",{attrs:{cols:"12",sm:"6"}},[r("div",{staticClass:"h2"},[e._v(e._s(e.title))])]),e._v(" "),r("v-col",{attrs:{cols:"12",sm:"6"}},[r("crm-default-forms-controls",{attrs:{editMode:e.editMode,isShowSpinner:e.isShowSpinner,link:e.link,create:e.create,edit:e.edit,isScrollable:!0}})],1),e._v(" "),r("v-col",{attrs:{cols:"12",sm:"12"}},[e._t("default")],2),e._v(" "),r("v-col",{attrs:{cols:"12",sm:"12"}},[r("crm-default-forms-controls",{attrs:{editMode:e.editMode,isShowSpinner:e.isShowSpinner,link:e.link,create:e.create,edit:e.edit,isScrollable:!1}})],1)],1)],1)],1)}),[],!1,null,"738a3ecd",null).exports},4600:(e,t,r)=>{r.r(t),r.d(t,{default:()=>f});function n(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function o(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?n(Object(r),!0).forEach((function(t){i(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):n(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function i(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const u={props:["editMode","isShowSpinner","link","create","edit","isScrollable"],data:function(){return{isPositionFixed:!1,isMobile:!1}},beforeDestroy:function(){"undefined"!=typeof window&&window.removeEventListener("resize",this.onResize,{passive:!0})},mounted:function(){this.onResize(),window.addEventListener("resize",this.onResize,{passive:!0})},methods:o(o({},(0,r(629).nv)({setIsShowUserWidget:"NavBarModule/setIsShowUserWidget"})),{},{onResize:function(){"undefined"!=typeof window&&this.isScrollable&&(window.innerWidth<960?(this.isMobile=!0,this.setIsShowUserWidget(!0)):(this.isMobile=!1,this.setIsShowUserWidget(!this.isPositionFixed)))},onScroll:function(e){"undefined"!=typeof window&&this.isScrollable&&((window.pageYOffset||e.target.scrollTop||0)>50?(this.isPositionFixed=!0,this.setIsShowUserWidget(this.isMobile)):(this.isPositionFixed=!1,this.setIsShowUserWidget(!0)))}})};var a=r(3379),s=r.n(a),l=r(2266),d={insert:"head",singleton:!1};s()(l.Z,d);l.Z.locals;const f=(0,r(1900).Z)(u,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{directives:[{name:"scroll",rawName:"v-scroll",value:e.onScroll,expression:"onScroll"}],staticClass:"page-controls",class:[e.isPositionFixed?"position-fixed":"",e.isScrollable?"d-none d-md-flex justify-end":"d-flex d-md-none justify-center"]},[e.editMode?e._e():r("v-btn",{staticClass:"mr-4",attrs:{disabled:e.isShowSpinner,color:"primary"},on:{click:e.create}},[e.isShowSpinner?r("span",[r("v-progress-circular",{attrs:{size:25,indeterminate:"",color:"grey"}})],1):r("span",[e._v("Створити")])]),e._v(" "),e.editMode?r("v-btn",{staticClass:"mr-4",attrs:{disabled:e.isShowSpinner,color:"primary"},on:{click:e.edit}},[e.isShowSpinner?r("span",[r("v-progress-circular",{attrs:{size:25,indeterminate:"",color:"grey"}})],1):r("span",[e._v("Редагувати")])]):e._e(),e._v(" "),r("router-link",{attrs:{to:e.link}},[r("v-btn",{attrs:{color:"secondary"}},[e._v("\n            Скасувати\n        ")])],1)],1)}),[],!1,null,"24c9b4a5",null).exports},7483:(e,t,r)=>{r.r(t),r.d(t,{default:()=>h});var n=r(8620),o=r(379),i=r(629),u=r(6357);function a(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function s(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?a(Object(r),!0).forEach((function(t){l(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):a(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function l(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const d={mixins:[n.oE],props:["editMode","title"],components:{CrmDefaultFormPage:u.default},validations:{landPurpose:{title:{required:o.C1,maxLength:(0,o.BS)(250)},order:{required:o.C1,maxValue:(0,o.PW)(2147483647)}}},data:function(){return{isShowSpinner:!1,isShowEye:!1}},computed:s(s({},(0,i.Se)({getLandPurpose:"LandPurposesModule/getLandPurpose"})),{},{landPurpose:{get:function(){return this.getLandPurpose},set:function(e){this.setLandPurpose(e)}},titleErrors:function(){var e=[];return this.$v.landPurpose.title.$dirty?(!this.$v.landPurpose.title.maxLength&&e.push("Максимальна довжина 250 символів"),!this.$v.landPurpose.title.required&&e.push("Поле назва обов'язкове"),e):e},orderErrors:function(){var e=[];return this.$v.landPurpose.order.$dirty?(!this.$v.landPurpose.order.maxValue&&e.push("Максимальне значення 2147483647"),!this.$v.landPurpose.order.required&&e.push("Поле порядок обов'язкове"),e):e}}),mounted:function(){var e=this;this.$nextTick((function(){e.$refs.title.focus()}))},methods:s(s({},(0,i.nv)({setLandPurpose:"LandPurposesModule/setLandPurpose"})),{},{create:function(){this.$v.$touch(),this.$v.$invalid||this.$emit("create")},edit:function(){this.$v.$touch(),this.$v.$invalid||this.$emit("edit")}})};var f=r(3379),c=r.n(f),p=r(5367),v={insert:"head",singleton:!1};c()(p.Z,v);p.Z.locals;const h=(0,r(1900).Z)(d,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("crm-default-form-page",{attrs:{editMode:e.editMode,title:e.title,isShowSpinner:e.isShowSpinner,link:{name:"dictionaries.land_purposes"},create:e.create,edit:e.edit}},[r("v-row",[r("v-col",{attrs:{cols:"12",sm:"6"}},[r("v-text-field",{ref:"title",attrs:{"error-messages":e.titleErrors,counter:250,label:"Назва",required:""},on:{input:function(t){return e.$v.landPurpose.title.$touch()},blur:function(t){return e.$v.landPurpose.title.$touch()}},model:{value:e.landPurpose.title,callback:function(t){e.$set(e.landPurpose,"title",t)},expression:"landPurpose.title"}})],1),e._v(" "),r("v-col",{attrs:{cols:"12",sm:"6"}},[r("v-text-field",{attrs:{type:"number","error-messages":e.orderErrors,label:"Порядок",required:""},on:{input:function(t){return e.$v.landPurpose.order.$touch()},blur:function(t){return e.$v.landPurpose.order.$touch()}},model:{value:e.landPurpose.order,callback:function(t){e.$set(e.landPurpose,"order",t)},expression:"landPurpose.order"}})],1)],1)],1)}),[],!1,null,"4fc7290e",null).exports},6408:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("alpha",/^[a-zA-Z]*$/);t.default=n},6195:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("alphaNum",/^[a-zA-Z0-9]*$/);t.default=n},5573:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++)t[r]=arguments[r];return(0,n.withParams)({type:"and"},(function(){for(var e=this,r=arguments.length,n=new Array(r),o=0;o<r;o++)n[o]=arguments[o];return t.length>0&&t.reduce((function(t,r){return t&&r.apply(e,n)}),!0)}))}},7884:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e,t){return(0,n.withParams)({type:"between",min:e,max:t},(function(r){return!(0,n.req)(r)||(!/\s/.test(r)||r instanceof Date)&&+e<=+r&&+t>=+r}))}},6681:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),Object.defineProperty(t,"withParams",{enumerable:!0,get:function(){return o.default}}),t.regex=t.ref=t.len=t.req=void 0;var n,o=(n=r(8085))&&n.__esModule?n:{default:n};function i(e){return i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},i(e)}var u=function(e){if(Array.isArray(e))return!!e.length;if(null==e)return!1;if(!1===e)return!0;if(e instanceof Date)return!isNaN(e.getTime());if("object"===i(e)){for(var t in e)return!0;return!1}return!!String(e).length};t.req=u;t.len=function(e){return Array.isArray(e)?e.length:"object"===i(e)?Object.keys(e).length:String(e).length};t.ref=function(e,t,r){return"function"==typeof e?e.call(t,r):r[e]};t.regex=function(e,t){return(0,o.default)({type:e},(function(e){return!u(e)||t.test(e)}))}},4078:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("decimal",/^[-]?\d*(\.\d+)?$/);t.default=n},8107:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("email",/^(?:[A-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[A-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]{2,}(?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/);t.default=n},379:(e,t,r)=>{Object.defineProperty(t,"Do",{enumerable:!0,get:function(){return a.default}}),Object.defineProperty(t,"BS",{enumerable:!0,get:function(){return d.default}}),Object.defineProperty(t,"Ei",{enumerable:!0,get:function(){return f.default}}),Object.defineProperty(t,"C1",{enumerable:!0,get:function(){return c.default}}),Object.defineProperty(t,"PW",{enumerable:!0,get:function(){return w.default}});var n=x(r(6408)),o=x(r(6195)),i=x(r(5669)),u=x(r(7884)),a=x(r(8107)),s=x(r(9103)),l=x(r(7340)),d=x(r(5287)),f=x(r(3091)),c=x(r(2419)),p=x(r(2941)),v=x(r(8300)),h=x(r(918)),y=x(r(3213)),b=x(r(5832)),m=x(r(5573)),P=x(r(2500)),g=x(r(2628)),w=x(r(301)),O=x(r(6673)),_=x(r(4078));function x(e){return e&&e.__esModule?e:{default:e}}(function(e){if(e&&e.__esModule)return e;var t={};if(null!=e)for(var r in e)if(Object.prototype.hasOwnProperty.call(e,r)){var n=Object.defineProperty&&Object.getOwnPropertyDescriptor?Object.getOwnPropertyDescriptor(e,r):{};n.get||n.set?Object.defineProperty(t,r,n):t[r]=e[r]}t.default=e})(r(6681))},6673:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("integer",/(^[0-9]*$)|(^-[0-9]+$)/);t.default=n},9103:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681),o=(0,n.withParams)({type:"ipAddress"},(function(e){if(!(0,n.req)(e))return!0;if("string"!=typeof e)return!1;var t=e.split(".");return 4===t.length&&t.every(i)}));t.default=o;var i=function(e){if(e.length>3||0===e.length)return!1;if("0"===e[0]&&"0"!==e)return!1;if(!e.match(/^\d+$/))return!1;var t=0|+e;return t>=0&&t<=255}},7340:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:":";return(0,n.withParams)({type:"macAddress"},(function(t){if(!(0,n.req)(t))return!0;if("string"!=typeof t)return!1;var r="string"==typeof e&&""!==e?t.split(e):12===t.length||16===t.length?t.match(/.{2}/g):null;return null!==r&&(6===r.length||8===r.length)&&r.every(o)}))};var o=function(e){return e.toLowerCase().match(/^[0-9a-f]{2}$/)}},5287:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"maxLength",max:e},(function(t){return!(0,n.req)(t)||(0,n.len)(t)<=e}))}},301:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"maxValue",max:e},(function(t){return!(0,n.req)(t)||(!/\s/.test(t)||t instanceof Date)&&+t<=+e}))}},3091:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"minLength",min:e},(function(t){return!(0,n.req)(t)||(0,n.len)(t)>=e}))}},2628:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"minValue",min:e},(function(t){return!(0,n.req)(t)||(!/\s/.test(t)||t instanceof Date)&&+t>=+e}))}},2500:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"not"},(function(t,r){return!(0,n.req)(t)||!e.call(this,t,r)}))}},5669:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("numeric",/^[0-9]*$/);t.default=n},5832:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++)t[r]=arguments[r];return(0,n.withParams)({type:"or"},(function(){for(var e=this,r=arguments.length,n=new Array(r),o=0;o<r;o++)n[o]=arguments[o];return t.length>0&&t.reduce((function(t,r){return t||r.apply(e,n)}),!1)}))}},2419:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681),o=(0,n.withParams)({type:"required"},(function(e){return"string"==typeof e?(0,n.req)(e.trim()):(0,n.req)(e)}));t.default=o},2941:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"requiredIf",prop:e},(function(t,r){return!(0,n.ref)(e,this,r)||(0,n.req)(t)}))}},8300:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"requiredUnless",prop:e},(function(t,r){return!!(0,n.ref)(e,this,r)||(0,n.req)(t)}))}},918:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=r(6681);t.default=function(e){return(0,n.withParams)({type:"sameAs",eq:e},(function(t,r){return t===(0,n.ref)(e,this,r)}))}},3213:(e,t,r)=>{Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=(0,r(6681).regex)("url",/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i);t.default=n},8085:(e,t,r)=>{var n=r(4155);Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var o="web"===n.env.BUILD?r(16).R:r(8413).withParams;t.default=o},16:(e,t,r)=>{function n(e){return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}t.R=void 0;var o="undefined"!=typeof window?window:void 0!==r.g?r.g:{},i=o.vuelidate?o.vuelidate.withParams:function(e,t){return"object"===n(e)&&void 0!==t?t:e((function(){}))};t.R=i}}]);