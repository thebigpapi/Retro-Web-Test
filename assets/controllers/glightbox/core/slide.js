import e from"./zoom.js";import t from"./drag.js";import i from"../slides/image.js";import s from"./slide-parser.js";import{addEvent as n,addClass as r,removeClass as l,hasClass as d,closest as o,isMobile as a,isFunction as c,isNode as g,createHTML as h}from"../utils/helpers.js";export default class m{constructor(e,t,i){this.element=e,this.instance=t,this.index=i}setContent(s=null,n=!1){if(d(s,"loaded"))return!1;let l=this.instance.settings,o=this.slideConfig,g=a();c(l.beforeSlideLoad)&&l.beforeSlideLoad({index:this.index,slide:s,player:!1});let h=o.type,m=o.descPosition,p=s.querySelector(".gslide-media"),f=s.querySelector(".gslide-title"),u=s.querySelector(".gslide-desc"),S=s.querySelector(".gdesc-inner"),L=n,b="gSlideTitle_"+this.index,x="gSlideDesc_"+this.index;if(c(l.afterSlideLoad)&&(L=()=>{c(n)&&n(),l.afterSlideLoad({index:this.index,slide:s,player:this.instance.getSlidePlayerInstance(this.index)})}),""==o.title&&""==o.description?S&&S.parentNode.parentNode.removeChild(S.parentNode):(f&&""!==o.title?(f.id=b,f.innerHTML=o.title):f.parentNode.removeChild(f),u&&""!==o.description?(u.id=x,g&&l.moreLength>0?(o.smallDescription=this.slideShortDesc(o.description,l.moreLength,l.moreText),u.innerHTML=o.smallDescription,this.descriptionEvents(u,o)):u.innerHTML=o.description):u.parentNode.removeChild(u),r(p.parentNode,`desc-${m}`),r(S.parentNode,`description-${m}`)),r(p,`gslide-${h}`),r(s,"loaded"),"image"===h){i(s,o,this.index,()=>{let i=s.querySelector("img");o.draggable&&new t({dragEl:i,toleranceX:l.dragToleranceX,toleranceY:l.dragToleranceY,slide:s,instance:this.instance}),o.zoomable&&i.naturalWidth>i.offsetWidth&&(r(i,"zoomable"),new e(i,s,()=>{this.instance.resize()})),c(L)&&L()});return}c(L)&&L()}slideShortDesc(e,t=50,i=!1){let s=document.createElement("div");s.innerHTML=e;let n;if((e=s.innerText.trim()).length<=t)return e;let r=e.substr(0,t-1);return i?(s=null,r+'... <a href="#" class="desc-more">'+i+"</a>"):r}descriptionEvents(e,t){let i=e.querySelector(".desc-more");if(!i)return!1;n("click",{onElement:i,withCallback:(e,i)=>{e.preventDefault();let s=document.body,d=o(i,".gslide-desc");if(!d)return!1;d.innerHTML=t.description,r(s,"gdesc-open");let a=n("click",{onElement:[s,o(d,".gslide-description")],withCallback:(e,i)=>{"a"!==e.target.nodeName.toLowerCase()&&(l(s,"gdesc-open"),r(s,"gdesc-closed"),d.innerHTML=t.smallDescription,this.descriptionEvents(d,t),setTimeout(()=>{l(s,"gdesc-closed")},400),a.destroy())}})}})}create(){return h(this.instance.settings.slideHTML)}getConfig(){g(this.element)||this.element.hasOwnProperty("draggable")||(this.element.draggable=this.instance.settings.draggable);let e=new s(this.instance.settings.slideExtraAttributes);return this.slideConfig=e.parseConfig(this.element,this.instance.settings),this.slideConfig}};