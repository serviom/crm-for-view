"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[7531,279,9458,429],{2785:(e,t,n)=>{n.d(t,{Z:()=>i});const i={methods:{applyPhoneMask:function(e){var t=0;return e?"+## (###) ###-####".replace(/#/g,(function(){return e[t++]})):""}}}},7582:(e,t,n)=>{n.d(t,{Z:()=>o});var i=n(3645),s=n.n(i)()((function(e){return e[1]}));s.push([e.id,".v-btn[data-v-6b826798]{min-width:150px!important}",""]);const o=s},6891:(e,t,n)=>{n.d(t,{Z:()=>o});var i=n(3645),s=n.n(i)()((function(e){return e[1]}));s.push([e.id,".controls[data-v-1d6ae0a4]{min-width:100px;width:100px}.alert-phone[data-v-1d6ae0a4]{font-size:14px;padding:5px 10px}.table-phone-number[data-v-1d6ae0a4]{min-width:220px}",""]);const o=s},279:(e,t,n)=>{n.r(t),n.d(t,{default:()=>s});const i={props:["headers","items","search","itemsPerPage","footerProps","options","serverItemsLength"],data:function(){return{total:0,innerOptions:this.options}},watch:{innerOptions:{handler:function(){this.$emit("update:options",this.innerOptions)},deep:!0},serverItemsLength:function(e){this.total=e}}};const s=(0,n(1900).Z)(i,(function(){var e=this,t=e.$createElement;return(e._self._c||t)("v-data-table",{staticClass:"elevation-1 set-tbody-d-table-row",attrs:{headers:e.headers,items:e.items,search:e.search,"items-per-page":e.itemsPerPage,"footer-props":e.footerProps,options:e.innerOptions,"server-items-length":e.total,"mobile-breakpoint":null},on:{"update:options":function(t){e.innerOptions=t}},scopedSlots:e._u([{key:"no-data",fn:function(){return[e._t("no-data")]},proxy:!0},{key:"no-results",fn:function(){return[e._t("no-results")]},proxy:!0},{key:"item",fn:function(t){var n=t.item,i=t.index;return[e._t("item",null,{item:n,index:i})]}}],null,!0)})}),[],!1,null,"75ca4795",null).exports},9458:(e,t,n)=>{n.r(t),n.d(t,{default:()=>s});const i={props:["isEnableNewItemBtn","newItemBtnLink","newItemBtnTitle","isShowDeleteDialog","isShowDeletionSpinner","deleteItemCallback","deleteItemTitle","itemToDelete","itemToDeleteProperty"],components:{CrmDialog:n(429).default},methods:{closeDialog:function(){this.$emit("closeDialog")}}};const s=(0,n(1900).Z)(i,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"pa-3"},[e.isEnableNewItemBtn?n("router-link",{attrs:{to:e.newItemBtnLink}},[n("v-btn",{staticClass:"mb-3",attrs:{color:"primary"}},[n("v-icon",[e._v("mdi-plus")]),e._v(e._s(e.newItemBtnTitle)+"\n        ")],1)],1):e._e(),e._v(" "),e._t("filters"),e._v(" "),e._t("table"),e._v(" "),n("crm-dialog",{attrs:{isShowDialog:e.isShowDeleteDialog,isShowSpinner:e.isShowDeletionSpinner,isAction:!0,maxWidth:"600",color:"warning",actionBtnText:"Видалити",defaultBtnText:"",cancelBtnText:""},on:{successEvent:e.deleteItemCallback,closeDialog:e.closeDialog},scopedSlots:e._u([{key:"info-title",fn:function(){return[e._v("\n            Увага!\n        ")]},proxy:!0},{key:"info-text",fn:function(){return[e._v("\n            Ви дійсно хочете видалити "+e._s(e.deleteItemTitle)+"\n            "),e.itemToDelete&&e.itemToDeleteProperty?n("b",[e._v(e._s(e.itemToDelete[e.itemToDeleteProperty]))]):e._e(),e._v("?\n        ")]},proxy:!0}])})],2)}),[],!1,null,"7f332e09",null).exports},429:(e,t,n)=>{n.r(t),n.d(t,{default:()=>a});const i={props:["maxWidth","color","isShowDialog","isShowSpinner","isAction","isCancelBtn","actionBtnText","defaultBtnText","cancelBtnText"],data:function(){return{isShow:!1}},watch:{isShowDialog:function(e){this.isShow=e},isShow:function(e){e||this.$emit("closeDialog")}},methods:{successEvent:function(){this.$emit("successEvent")},closeDialog:function(){this.$emit("closeDialog")}}};var s=n(3379),o=n.n(s),r=n(7582),l={insert:"head",singleton:!1};o()(r.Z,l);r.Z.locals;const a=(0,n(1900).Z)(i,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("v-dialog",{attrs:{transition:"dialog-bottom-transition","max-width":e.maxWidth||600},scopedSlots:e._u([{key:"default",fn:function(t){return[n("v-card",{staticClass:"pa-0 pb-6"},[n("v-toolbar",{staticClass:"text-h4",attrs:{color:e.color,dark:""}},[e._t("info-title")],2),e._v(" "),n("v-card-text",[n("div",{staticClass:"pt-5"},[e._t("info-text")],2)]),e._v(" "),n("v-card-actions",{staticClass:"justify-center"},[e.isAction?n("v-btn",{staticClass:"text-white mr-4",attrs:{disabled:e.isShowSpinner,color:e.color},on:{click:e.successEvent}},[e.isShowSpinner?n("span",[n("v-progress-circular",{attrs:{size:25,indeterminate:"",color:"grey"}})],1):n("span",[e._v(e._s(e.actionBtnText))])]):n("v-btn",{staticClass:"text-white mr-4",attrs:{color:e.color},on:{click:e.successEvent}},[n("span",[e._v(e._s(e.defaultBtnText))])]),e._v(" "),null===e.isCancelBtn||e.isCancelBtn?n("v-btn",{on:{click:e.closeDialog}},[e._v("\n                    "+e._s(e.cancelBtnText||"Скасувати")+"\n                ")]):e._e()],1)],1)]}}],null,!0),model:{value:e.isShow,callback:function(t){e.isShow=t},expression:"isShow"}})}),[],!1,null,"6b826798",null).exports},7531:(e,t,n)=>{n.r(t),n.d(t,{default:()=>v});var i=n(279),s=n(9458),o=n(429),r=n(6486),l=n(629);function a(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);t&&(i=i.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,i)}return n}function c(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?a(Object(n),!0).forEach((function(t){u(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):a(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function u(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}const p={mixins:[n(2785).Z],components:{CrmDefaultListingPage:s.default,CrmDataTablePagination:i.default,CrmDialog:o.default},data:function(){return{isShowTableSpinner:!1,isShowDeleteDialog:!1,isShowDeletionSpinner:!1,headers:[{text:"Ім'я",align:"start",sortable:!0,value:"fio"},{text:"Телефони",align:"start",sortable:!1,value:null},{text:"Користувач",align:"start",sortable:!0,value:"user"},{text:"Дата створення",align:"start",sortable:!0,value:"created_at"},{text:"",align:"start",sortable:!1,value:null}],itemsPerPageOptions:[10,20,30,40,50],itemsPerPageText:"Рядків на сторіку",itemsPerPageAllText:"Всі",search:null,filterUser:null,filterClient:null,filterPhone:null,itemToDelete:null,totalClients:0,options:{}}},computed:c(c({},(0,l.Se)({getClientsList:"ClientsModule/getClients",getAllUsersList:"ClientsModule/getAllUsers"})),{},{getUsersListForFilter:function(){return[{name:"Всі",id:"-1"},{name:"Немає користувача",id:"-"}].concat((0,r.cloneDeep)(this.getAllUsersList,!0))}}),watch:{options:{handler:function(e,t){0!==Object.keys(e).length&&this.getClients()},deep:!0}},mounted:function(){this.getUsers()},methods:c(c({},(0,l.nv)({setClients:"ClientsModule/setClients",setAllUsers:"ClientsModule/setAllUsers",incrementSpinnerCounter:"SpinnerModule/incrementSpinnerCounter",decrementSpinnerCounter:"SpinnerModule/decrementSpinnerCounter"})),{},{applyFilters:function(){this.options.page=1,this.getClients()},resetFilters:function(){this.filterUser=null,this.filterClient=null,this.filterPhone=null,this.options.page=1,this.getClients()},getClients:function(){var e=this;this.incrementSpinnerCounter();var t=this.options,n=t.sortBy,i=t.sortDesc,s=t.page,o=t.itemsPerPage;this.axios.get("clients?",{params:{sortBy:n.length?n[0]:null,sortDesc:i.length?i[0]?1:0:null,page:s,itemsPerPage:o,filterUser:this.filterUser,filterClient:this.filterClient,filterPhone:this.filterPhone}}).then((function(t){e.setClients(t.data.data),e.totalClients=t.data.count})).catch((function(e){})).then((function(){e.decrementSpinnerCounter()}))},getUsers:function(){var e=this;this.incrementSpinnerCounter(),this.axios.get("clients/all-users").then((function(t){e.setAllUsers(t.data.data)})).catch((function(e){})).then((function(){e.decrementSpinnerCounter()}))},showDeleteDialog:function(e){this.itemToDelete=e,this.isShowDeleteDialog=!0},deleteItemCallback:function(){var e=this;this.isShowDeletionSpinner=!0,this.axios.delete("clients/".concat(this.itemToDelete.id)).then((function(t){var n=t.data.message;e.eventHub.$emit("doShowSnackbarEvent",!0,n,"success",5e3)})).catch((function(t){var n=t.data.message||"Щось погане трапилось :(";e.eventHub.$emit("doShowSnackbarEvent",!0,n,"warning",5e3)})).then((function(){e.isShowDeletionSpinner=!1,e.isShowDeleteDialog=!1,e.getClients()}))}})};var d=n(3379),m=n.n(d),h=n(6891),f={insert:"head",singleton:!1};m()(h.Z,f);h.Z.locals;const v=(0,n(1900).Z)(p,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("crm-default-listing-page",{attrs:{newItemBtnTitle:"Новий клієнт",isEnableNewItemBtn:e.$auth.check(["SuperAdmin","clients.create"],"permissions"),newItemBtnLink:{name:"clients.create"},isShowDeleteDialog:e.isShowDeleteDialog,isShowDeletionSpinner:e.isShowDeletionSpinner,deleteItemCallback:e.deleteItemCallback,deleteItemTitle:"клієнта",itemToDelete:e.itemToDelete,itemToDeleteProperty:"fio"},on:{closeDialog:function(t){e.isShowDeleteDialog=!1}},scopedSlots:e._u([{key:"filters",fn:function(){return[n("form",{ref:"form",on:{submit:function(t){return t.preventDefault(),e.applyFilters.apply(null,arguments)}}},[n("v-container",{attrs:{fluid:""}},[n("v-row",{staticClass:"justify-end"},[n("v-col",{staticClass:"mb-6",attrs:{cols:"12",sm:"3"}},[n("v-text-field",{attrs:{label:"Клієнт","hide-details":""},model:{value:e.filterClient,callback:function(t){e.filterClient=t},expression:"filterClient"}})],1),e._v(" "),n("v-col",{staticClass:"mb-6",attrs:{cols:"12",sm:"3"}},[n("v-autocomplete",{attrs:{items:e.getUsersListForFilter,"item-text":"name","item-value":"id",label:"Користувач"},model:{value:e.filterUser,callback:function(t){e.filterUser=t},expression:"filterUser"}})],1),e._v(" "),n("v-col",{staticClass:"mb-6",attrs:{cols:"12",sm:"3"}},[n("v-text-field",{attrs:{label:"Телефон","hide-details":""},model:{value:e.filterPhone,callback:function(t){e.filterPhone=t},expression:"filterPhone"}})],1),e._v(" "),n("v-col",{staticClass:"mb-6 d-flex align-items-center",attrs:{cols:"12",sm:"3"}},[n("v-btn",{staticClass:"mr-3",attrs:{color:"success",type:"submit"}},[n("v-icon",[e._v("mdi-magnify")])],1),e._v(" "),n("v-btn",{attrs:{color:"light"},on:{click:e.resetFilters}},[n("v-icon",[e._v("mdi-close-thick")])],1)],1)],1)],1)],1)]},proxy:!0},{key:"table",fn:function(){return[n("crm-data-table-pagination",{staticClass:"set-tbody-d-table-row",attrs:{headers:e.headers,items:e.getClientsList,"items-per-page":10,options:e.options,"server-items-length":e.totalClients,"footer-props":{"items-per-page-options":e.itemsPerPageOptions,"items-per-page-text":e.itemsPerPageText,"items-per-page-all-text":e.itemsPerPageAllText}},on:{"update:options":function(t){e.options=t}},scopedSlots:e._u([{key:"no-data",fn:function(){return[e.isShowTableSpinner?n("v-progress-circular",{attrs:{indeterminate:"",color:"primary"}}):n("span",[e._v("Немає клієнтів")])]},proxy:!0},{key:"no-results",fn:function(){return[n("span",[e._v("Немає результатів пошуку")])]},proxy:!0},{key:"item",fn:function(t){var i=t.item;t.index;return[n("tr",[n("td",[e._v(e._s(i.fio))]),e._v(" "),n("td",{staticClass:"table-phone-number pt-3"},e._l(i.phoneNumbers,(function(t){return n("a",{key:t.id,staticClass:"text-white",attrs:{href:"tel:"+e.applyPhoneMask(t.phoneNumber)}},[n("v-alert",{staticClass:"d-inline-block alert-phone m-0 mr-3 mb-3",attrs:{shaped:"",dark:"",color:"success"}},[e._v("\n                                "+e._s(e.applyPhoneMask(t.phoneNumber))+"\n                            ")])],1)})),0),e._v(" "),n("td",[i.user?n("router-link",{attrs:{to:{name:"users.update",params:{id:i.user.id}}}},[e._v("\n                            "+e._s(i.user.name)+"\n                        ")]):n("span",[e._v("-")])],1),e._v(" "),n("td",[e._v("\n                        "+e._s(i.created_at)+"\n                    ")]),e._v(" "),n("td",{staticClass:"controls"},[n("div",{staticClass:"d-none d-md-flex"},[e.$auth.check(["SuperAdmin","clients.update"],"permissions")&&e.$auth.check(["SuperAdmin","clients.view"],"permissions")?n("v-tooltip",{attrs:{left:""},scopedSlots:e._u([{key:"activator",fn:function(t){var s=t.on,o=t.attrs;return[n("router-link",{attrs:{to:{name:"clients.update",params:{id:i.id}}}},[n("span",e._g(e._b({staticClass:"control-edit mr-3 cursor-pointer"},"span",o,!1),s),[n("v-icon",{attrs:{color:"success"}},[e._v("mdi-pencil")])],1)])]}}],null,!0)},[e._v(" "),n("span",[e._v("Редагувати")])]):e._e(),e._v(" "),e.$auth.check(["SuperAdmin","clients.delete"],"permissions")?n("v-tooltip",{attrs:{left:""},scopedSlots:e._u([{key:"activator",fn:function(t){var s=t.on,o=t.attrs;return[n("span",e._g(e._b({staticClass:"control-delete cursor-pointer",on:{click:function(t){return e.showDeleteDialog(i)}}},"span",o,!1),s),[n("v-icon",{attrs:{color:"red"}},[e._v("mdi-delete")])],1)]}}],null,!0)},[e._v(" "),n("span",[e._v("Видалити")])]):e._e()],1),e._v(" "),n("div",{staticClass:"d-flex d-md-none"},[e.$auth.check(["SuperAdmin","clients.update"],"permissions")&&e.$auth.check(["SuperAdmin","clients.view"],"permissions")?n("router-link",{attrs:{to:{name:"clients.update",params:{id:i.id}}}},[n("span",{staticClass:"control-edit mr-3 cursor-pointer"},[n("v-icon",{attrs:{color:"success"}},[e._v("mdi-pencil")])],1)]):e._e(),e._v(" "),e.$auth.check(["SuperAdmin","clients.delete"],"permissions")?n("span",{staticClass:"control-delete cursor-pointer",on:{click:function(t){return e.showDeleteDialog(i)}}},[n("v-icon",{attrs:{color:"red"}},[e._v("mdi-delete")])],1):e._e()],1)])])]}}])})]},proxy:!0}])})}),[],!1,null,"1d6ae0a4",null).exports}}]);