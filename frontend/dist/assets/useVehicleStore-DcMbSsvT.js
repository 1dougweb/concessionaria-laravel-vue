import{m as t,n as i}from"./index-BmhWz_z3.js";const o=t("vehicles",{state:()=>({items:[],isLoading:!1}),actions:{async fetch(s={}){this.isLoading=!0;const{data:e}=await i.get("/vehicles",{params:s});this.items=e.data??e,this.isLoading=!1}}});export{o as u};
//# sourceMappingURL=useVehicleStore-DcMbSsvT.js.map
