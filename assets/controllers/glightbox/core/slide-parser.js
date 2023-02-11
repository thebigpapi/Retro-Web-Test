import{extend as e,has as t,each as i,isNil as s,isNode as o,isObject as h,isNumber as a}from"../utils/helpers.js";export default class c{constructor(t={}){this.defaults={href:"",sizes:"",srcset:"",title:"",type:"",videoProvider:"",description:"",alt:"",descPosition:"bottom",effect:"",width:"",height:"",content:!1,zoomable:!0,draggable:!0},h(t)&&(this.defaults=e(this.defaults,t))}sourceType(e){let t=e;return null!==(e=e.toLowerCase()).match(/\.(jpeg|jpg|jpe|gif|png|apn|webp|avif|svg)/)?"image":e.match(/(youtube\.com|youtube-nocookie\.com)\/watch\?v=([a-zA-Z0-9\-_]+)/)||e.match(/youtu\.be\/([a-zA-Z0-9\-_]+)/)||e.match(/(youtube\.com|youtube-nocookie\.com)\/embed\/([a-zA-Z0-9\-_]+)/)||e.match(/vimeo\.com\/([0-9]*)/)||null!==e.match(/\.(mp4|ogg|webm|mov)/)?"video":null!==e.match(/\.(mp3|wav|wma|aac|ogg)/)?"audio":e.indexOf("#")>-1&&""!==t.split("#").pop().trim()?"inline":e.indexOf("goajax=true")>-1?"ajax":"external"}parseConfig(a,c){let r=e({descPosition:c.descPosition},this.defaults);if(h(a)&&!o(a)){!t(a,"type")&&(t(a,"content")&&a.content?a.type="inline":t(a,"href")&&(a.type=this.sourceType(a.href)));let l=e(r,a);return this.setSize(l,c),l}let n="",u=a.getAttribute("data-glightbox"),d=a.nodeName.toLowerCase();if("a"===d&&(n=a.href),"img"===d&&(n=a.src,r.alt=a.alt),r.href=n,i(r,(e,i)=>{t(c,i)&&"width"!==i&&(r[i]=c[i]);let o=a.dataset[i];s(o)||(r[i]=this.sanitizeValue(o))}),r.content&&(r.type="inline"),!r.type&&n&&(r.type=this.sourceType(n)),s(u)){if(!r.title&&"a"==d){let p=a.title;s(p)||""===p||(r.title=p)}if(!r.title&&"img"==d){let m=a.alt;s(m)||""===m||(r.title=m)}}else{let g=[];i(r,(e,t)=>{g.push(";\\s?"+t)}),g=g.join("\\s?:|"),""!==u.trim()&&i(r,(e,t)=>{let i="s?"+t+"s?:s?(.*?)("+g+"s?:|$)",s=RegExp(i),o=u.match(s);if(o&&o.length&&o[1]){let h=o[1].trim().replace(/;\s*$/,"");r[t]=this.sanitizeValue(h)}})}if(r.description&&"."===r.description.substring(0,1)){let f;try{f=document.querySelector(r.description).innerHTML}catch(y){if(!(y instanceof DOMException))throw y}f&&(r.description=f)}if(!r.description){let z=a.querySelector(".glightbox-desc");z&&(r.description=z.innerHTML)}return this.setSize(r,c,a),this.slideConfig=r,r}setSize(e,i,s=null){let o="video"==e.type?this.checkSize(i.videosWidth):this.checkSize(i.width),h=this.checkSize(i.height);return e.width=t(e,"width")&&""!==e.width?this.checkSize(e.width):o,e.height=t(e,"height")&&""!==e.height?this.checkSize(e.height):h,s&&"image"==e.type&&(e._hasCustomWidth=!!s.dataset.width,e._hasCustomHeight=!!s.dataset.height),e}checkSize(e){return a(e)?`${e}px`:e}sanitizeValue(e){return"true"!==e&&"false"!==e?e:"true"===e}};