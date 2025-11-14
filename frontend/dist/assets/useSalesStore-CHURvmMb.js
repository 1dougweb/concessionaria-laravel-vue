import{m as t,n as e}from"./index-BmhWz_z3.js";const o=t("sales",{state:()=>({items:[],isLoading:!1}),actions:{async fetch(a={}){this.isLoading=!0;const{data:s}=await e.get("/sales",{params:a});this.items=s.data??s,this.isLoading=!1}}});export{o as u};
//# sourceMappingURL=useSalesStore-CHURvmMb.js.map
