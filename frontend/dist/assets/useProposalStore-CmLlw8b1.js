import{m as i,n as a}from"./index-BmhWz_z3.js";const e=i("proposals",{state:()=>({items:[],isLoading:!1}),actions:{async fetch(s={}){this.isLoading=!0;const{data:t}=await a.get("/proposals",{params:s});this.items=t.data??t,this.isLoading=!1},async submit(s){await a.post(`/proposals/${s}/submit`),await this.fetch()}}});export{e as u};
//# sourceMappingURL=useProposalStore-CmLlw8b1.js.map
