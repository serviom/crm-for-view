"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[6357,4600],{2266:(e,t,i)=>{i.d(t,{Z:()=>o});var s=i(3645),r=i.n(s)()((function(e){return e[1]}));r.push([e.id,".page-controls.position-fixed[data-v-24c9b4a5]{right:24px;top:14px;z-index:5}",""]);const o=r},6357:(e,t,i)=>{i.r(t),i.d(t,{default:()=>r});const s={props:["editMode","title","isShowSpinner","link","create","edit"],components:{CrmDefaultFormsControls:i(4600).default}};const r=(0,i(1900).Z)(s,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("form",[i("v-container",{attrs:{fluid:""}},[i("v-row",[i("v-col",{attrs:{cols:"12",sm:"6"}},[i("div",{staticClass:"h2"},[e._v(e._s(e.title))])]),e._v(" "),i("v-col",{attrs:{cols:"12",sm:"6"}},[i("crm-default-forms-controls",{attrs:{editMode:e.editMode,isShowSpinner:e.isShowSpinner,link:e.link,create:e.create,edit:e.edit,isScrollable:!0}})],1),e._v(" "),i("v-col",{attrs:{cols:"12",sm:"12"}},[e._t("default")],2),e._v(" "),i("v-col",{attrs:{cols:"12",sm:"12"}},[i("crm-default-forms-controls",{attrs:{editMode:e.editMode,isShowSpinner:e.isShowSpinner,link:e.link,create:e.create,edit:e.edit,isScrollable:!1}})],1)],1)],1)],1)}),[],!1,null,"738a3ecd",null).exports},4600:(e,t,i)=>{i.r(t),i.d(t,{default:()=>p});function s(e,t){var i=Object.keys(e);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);t&&(s=s.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),i.push.apply(i,s)}return i}function r(e){for(var t=1;t<arguments.length;t++){var i=null!=arguments[t]?arguments[t]:{};t%2?s(Object(i),!0).forEach((function(t){o(e,t,i[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(i)):s(Object(i)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(i,t))}))}return e}function o(e,t,i){return t in e?Object.defineProperty(e,t,{value:i,enumerable:!0,configurable:!0,writable:!0}):e[t]=i,e}const n={props:["editMode","isShowSpinner","link","create","edit","isScrollable"],data:function(){return{isPositionFixed:!1,isMobile:!1}},beforeDestroy:function(){"undefined"!=typeof window&&window.removeEventListener("resize",this.onResize,{passive:!0})},mounted:function(){this.onResize(),window.addEventListener("resize",this.onResize,{passive:!0})},methods:r(r({},(0,i(629).nv)({setIsShowUserWidget:"NavBarModule/setIsShowUserWidget"})),{},{onResize:function(){"undefined"!=typeof window&&this.isScrollable&&(window.innerWidth<960?(this.isMobile=!0,this.setIsShowUserWidget(!0)):(this.isMobile=!1,this.setIsShowUserWidget(!this.isPositionFixed)))},onScroll:function(e){"undefined"!=typeof window&&this.isScrollable&&((window.pageYOffset||e.target.scrollTop||0)>50?(this.isPositionFixed=!0,this.setIsShowUserWidget(this.isMobile)):(this.isPositionFixed=!1,this.setIsShowUserWidget(!0)))}})};var l=i(3379),c=i.n(l),a=i(2266),d={insert:"head",singleton:!1};c()(a.Z,d);a.Z.locals;const p=(0,i(1900).Z)(n,(function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{directives:[{name:"scroll",rawName:"v-scroll",value:e.onScroll,expression:"onScroll"}],staticClass:"page-controls",class:[e.isPositionFixed?"position-fixed":"",e.isScrollable?"d-none d-md-flex justify-end":"d-flex d-md-none justify-center"]},[e.editMode?e._e():i("v-btn",{staticClass:"mr-4",attrs:{disabled:e.isShowSpinner,color:"primary"},on:{click:e.create}},[e.isShowSpinner?i("span",[i("v-progress-circular",{attrs:{size:25,indeterminate:"",color:"grey"}})],1):i("span",[e._v("Створити")])]),e._v(" "),e.editMode?i("v-btn",{staticClass:"mr-4",attrs:{disabled:e.isShowSpinner,color:"primary"},on:{click:e.edit}},[e.isShowSpinner?i("span",[i("v-progress-circular",{attrs:{size:25,indeterminate:"",color:"grey"}})],1):i("span",[e._v("Редагувати")])]):e._e(),e._v(" "),i("router-link",{attrs:{to:e.link}},[i("v-btn",{attrs:{color:"secondary"}},[e._v("\n            Скасувати\n        ")])],1)],1)}),[],!1,null,"24c9b4a5",null).exports}}]);