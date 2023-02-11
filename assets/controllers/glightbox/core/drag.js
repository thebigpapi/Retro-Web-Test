import{closest as t}from"../utils/helpers.js";export default class i{constructor(t={}){let{dragEl:i,toleranceX:s=40,toleranceY:e=65,slide:n=null,instance:a=null}=t;this.el=i,this.active=!1,this.dragging=!1,this.currentX=null,this.currentY=null,this.initialX=null,this.initialY=null,this.xOffset=0,this.yOffset=0,this.direction=null,this.lastDirection=null,this.toleranceX=s,this.toleranceY=e,this.toleranceReached=!1,this.dragContainer=this.el,this.slide=n,this.instance=a,this.el.addEventListener("mousedown",t=>this.dragStart(t),!1),this.el.addEventListener("mouseup",t=>this.dragEnd(t),!1),this.el.addEventListener("mousemove",t=>this.drag(t),!1)}dragStart(i){if(this.slide.classList.contains("zoomed")){this.active=!1;return}"touchstart"===i.type?(this.initialX=i.touches[0].clientX-this.xOffset,this.initialY=i.touches[0].clientY-this.yOffset):(this.initialX=i.clientX-this.xOffset,this.initialY=i.clientY-this.yOffset);let s=i.target.nodeName.toLowerCase();if(i.target.classList.contains("nodrag")||t(i.target,".nodrag")||-1!==["input","select","textarea","button","a"].indexOf(s)){this.active=!1;return}i.preventDefault(),(i.target===this.el||"img"!==s&&t(i.target,".gslide-inline"))&&(this.active=!0,this.el.classList.add("dragging"),this.dragContainer=t(i.target,".ginner-container"))}dragEnd(t){t&&t.preventDefault(),this.initialX=0,this.initialY=0,this.currentX=null,this.currentY=null,this.initialX=null,this.initialY=null,this.xOffset=0,this.yOffset=0,this.active=!1,this.doSlideChange&&(this.instance.preventOutsideClick=!0,"right"==this.doSlideChange&&this.instance.prevSlide(),"left"==this.doSlideChange&&this.instance.nextSlide()),this.doSlideClose&&this.instance.close(),this.toleranceReached||this.setTranslate(this.dragContainer,0,0,!0),setTimeout(()=>{this.instance.preventOutsideClick=!1,this.toleranceReached=!1,this.lastDirection=null,this.dragging=!1,this.el.isDragging=!1,this.el.classList.remove("dragging"),this.slide.classList.remove("dragging-nav"),this.dragContainer.style.transform="",this.dragContainer.style.transition=""},100)}drag(t){if(this.active){t.preventDefault(),this.slide.classList.add("dragging-nav"),"touchmove"===t.type?(this.currentX=t.touches[0].clientX-this.initialX,this.currentY=t.touches[0].clientY-this.initialY):(this.currentX=t.clientX-this.initialX,this.currentY=t.clientY-this.initialY),this.xOffset=this.currentX,this.yOffset=this.currentY,this.el.isDragging=!0,this.dragging=!0,this.doSlideChange=!1,this.doSlideClose=!1;let i=Math.abs(this.currentX),s=Math.abs(this.currentY);if(i>0&&i>=Math.abs(this.currentY)&&(!this.lastDirection||"x"==this.lastDirection)){this.yOffset=0,this.lastDirection="x",this.setTranslate(this.dragContainer,this.currentX,0);let e=this.shouldChange();if(!this.instance.settings.dragAutoSnap&&e&&(this.doSlideChange=e),this.instance.settings.dragAutoSnap&&e){this.instance.preventOutsideClick=!0,this.toleranceReached=!0,this.active=!1,this.instance.preventOutsideClick=!0,this.dragEnd(null),"right"==e&&this.instance.prevSlide(),"left"==e&&this.instance.nextSlide();return}}if(this.toleranceY>0&&s>0&&s>=i&&(!this.lastDirection||"y"==this.lastDirection)){this.xOffset=0,this.lastDirection="y",this.setTranslate(this.dragContainer,0,this.currentY);let n=this.shouldClose();!this.instance.settings.dragAutoSnap&&n&&(this.doSlideClose=!0),this.instance.settings.dragAutoSnap&&n&&this.instance.close();return}}}shouldChange(){let t=!1;if(Math.abs(this.currentX)>=this.toleranceX){let i=this.currentX>0?"right":"left";("left"==i&&this.slide!==this.slide.parentNode.lastChild||"right"==i&&this.slide!==this.slide.parentNode.firstChild)&&(t=i)}return t}shouldClose(){let t=!1;return Math.abs(this.currentY)>=this.toleranceY&&(t=!0),t}setTranslate(t,i,s,e=!1){e?t.style.transition="all .2s ease":t.style.transition="",t.style.transform=`translate3d(${i}px, ${s}px, 0)`}};