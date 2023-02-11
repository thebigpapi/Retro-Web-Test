function getLen(t){return Math.sqrt(t.x*t.x+t.y*t.y)}function dot(t,e){return t.x*e.x+t.y*e.y}function getAngle(t,e){var i=getLen(t)*getLen(e);if(0===i)return 0;var s=dot(t,e)/i;return s>1&&(s=1),Math.acos(s)}function cross(t,e){return t.x*e.y-e.x*t.y}function getRotateAngle(t,e){var i=getAngle(t,e);return cross(t,e)>0&&(i*=-1),180*i/Math.PI}class EventsHandlerAdmin{constructor(t){this.handlers=[],this.el=t}add(t){this.handlers.push(t)}del(t){t||(this.handlers=[]);for(var e=this.handlers.length;e>=0;e--)this.handlers[e]===t&&this.handlers.splice(e,1)}dispatch(){for(var t=0,e=this.handlers.length;t<e;t++){var i=this.handlers[t];"function"==typeof i&&i.apply(this.el,arguments)}}}function wrapFunc(t,e){var i=new EventsHandlerAdmin(t);return i.add(e),i}export default class t{constructor(t,e){this.element="string"==typeof t?document.querySelector(t):t,this.start=this.start.bind(this),this.move=this.move.bind(this),this.end=this.end.bind(this),this.cancel=this.cancel.bind(this),this.element.addEventListener("touchstart",this.start,!1),this.element.addEventListener("touchmove",this.move,!1),this.element.addEventListener("touchend",this.end,!1),this.element.addEventListener("touchcancel",this.cancel,!1),this.preV={x:null,y:null},this.pinchStartLen=null,this.zoom=1,this.isDoubleTap=!1;var i=function(){};this.rotate=wrapFunc(this.element,e.rotate||i),this.touchStart=wrapFunc(this.element,e.touchStart||i),this.multipointStart=wrapFunc(this.element,e.multipointStart||i),this.multipointEnd=wrapFunc(this.element,e.multipointEnd||i),this.pinch=wrapFunc(this.element,e.pinch||i),this.swipe=wrapFunc(this.element,e.swipe||i),this.tap=wrapFunc(this.element,e.tap||i),this.doubleTap=wrapFunc(this.element,e.doubleTap||i),this.longTap=wrapFunc(this.element,e.longTap||i),this.singleTap=wrapFunc(this.element,e.singleTap||i),this.pressMove=wrapFunc(this.element,e.pressMove||i),this.twoFingerPressMove=wrapFunc(this.element,e.twoFingerPressMove||i),this.touchMove=wrapFunc(this.element,e.touchMove||i),this.touchEnd=wrapFunc(this.element,e.touchEnd||i),this.touchCancel=wrapFunc(this.element,e.touchCancel||i),this.translateContainer=this.element,this._cancelAllHandler=this.cancelAll.bind(this),window.addEventListener("scroll",this._cancelAllHandler),this.delta=null,this.last=null,this.now=null,this.tapTimeout=null,this.singleTapTimeout=null,this.longTapTimeout=null,this.swipeTimeout=null,this.x1=this.x2=this.y1=this.y2=null,this.preTapPosition={x:null,y:null}}start(t){if(t.touches){if(t.target&&t.target.nodeName&&["a","button","input"].indexOf(t.target.nodeName.toLowerCase())>=0){console.log("ignore drag for this touched element",t.target.nodeName.toLowerCase());return}this.now=Date.now(),this.x1=t.touches[0].pageX,this.y1=t.touches[0].pageY,this.delta=this.now-(this.last||this.now),this.touchStart.dispatch(t,this.element),null!==this.preTapPosition.x&&(this.isDoubleTap=this.delta>0&&this.delta<=250&&30>Math.abs(this.preTapPosition.x-this.x1)&&30>Math.abs(this.preTapPosition.y-this.y1),this.isDoubleTap&&clearTimeout(this.singleTapTimeout)),this.preTapPosition.x=this.x1,this.preTapPosition.y=this.y1,this.last=this.now;var e=this.preV;if(t.touches.length>1){this._cancelLongTap(),this._cancelSingleTap();var i={x:t.touches[1].pageX-this.x1,y:t.touches[1].pageY-this.y1};e.x=i.x,e.y=i.y,this.pinchStartLen=getLen(e),this.multipointStart.dispatch(t,this.element)}this._preventTap=!1,this.longTapTimeout=setTimeout((function(){this.longTap.dispatch(t,this.element),this._preventTap=!0}).bind(this),750)}}move(t){if(t.touches){var e=this.preV,i=t.touches.length,s=t.touches[0].pageX,h=t.touches[0].pageY;if(this.isDoubleTap=!1,i>1){var n=t.touches[1].pageX,l=t.touches[1].pageY,a={x:t.touches[1].pageX-s,y:t.touches[1].pageY-h};null!==e.x&&(this.pinchStartLen>0&&(t.zoom=getLen(a)/this.pinchStartLen,this.pinch.dispatch(t,this.element)),t.angle=getRotateAngle(a,e),this.rotate.dispatch(t,this.element)),e.x=a.x,e.y=a.y,null!==this.x2&&null!==this.sx2?(t.deltaX=(s-this.x2+n-this.sx2)/2,t.deltaY=(h-this.y2+l-this.sy2)/2):(t.deltaX=0,t.deltaY=0),this.twoFingerPressMove.dispatch(t,this.element),this.sx2=n,this.sy2=l}else{if(null!==this.x2){t.deltaX=s-this.x2,t.deltaY=h-this.y2;var o=Math.abs(this.x1-this.x2),p=Math.abs(this.y1-this.y2);(o>10||p>10)&&(this._preventTap=!0)}else t.deltaX=0,t.deltaY=0;this.pressMove.dispatch(t,this.element)}this.touchMove.dispatch(t,this.element),this._cancelLongTap(),this.x2=s,this.y2=h,i>1&&t.preventDefault()}}end(t){if(t.changedTouches){this._cancelLongTap();var e=this;t.touches.length<2&&(this.multipointEnd.dispatch(t,this.element),this.sx2=this.sy2=null),this.x2&&Math.abs(this.x1-this.x2)>30||this.y2&&Math.abs(this.y1-this.y2)>30?(t.direction=this._swipeDirection(this.x1,this.x2,this.y1,this.y2),this.swipeTimeout=setTimeout(function(){e.swipe.dispatch(t,e.element)},0)):(this.tapTimeout=setTimeout(function(){e._preventTap||e.tap.dispatch(t,e.element),e.isDoubleTap&&(e.doubleTap.dispatch(t,e.element),e.isDoubleTap=!1)},0),e.isDoubleTap||(e.singleTapTimeout=setTimeout(function(){e.singleTap.dispatch(t,e.element)},250))),this.touchEnd.dispatch(t,this.element),this.preV.x=0,this.preV.y=0,this.zoom=1,this.pinchStartLen=null,this.x1=this.x2=this.y1=this.y2=null}}cancelAll(){this._preventTap=!0,clearTimeout(this.singleTapTimeout),clearTimeout(this.tapTimeout),clearTimeout(this.longTapTimeout),clearTimeout(this.swipeTimeout)}cancel(t){this.cancelAll(),this.touchCancel.dispatch(t,this.element)}_cancelLongTap(){clearTimeout(this.longTapTimeout)}_cancelSingleTap(){clearTimeout(this.singleTapTimeout)}_swipeDirection(t,e,i,s){return Math.abs(t-e)>=Math.abs(i-s)?t-e>0?"Left":"Right":i-s>0?"Up":"Down"}on(t,e){this[t]&&this[t].add(e)}off(t,e){this[t]&&this[t].del(e)}destroy(){return this.singleTapTimeout&&clearTimeout(this.singleTapTimeout),this.tapTimeout&&clearTimeout(this.tapTimeout),this.longTapTimeout&&clearTimeout(this.longTapTimeout),this.swipeTimeout&&clearTimeout(this.swipeTimeout),this.element.removeEventListener("touchstart",this.start),this.element.removeEventListener("touchmove",this.move),this.element.removeEventListener("touchend",this.end),this.element.removeEventListener("touchcancel",this.cancel),this.rotate.del(),this.touchStart.del(),this.multipointStart.del(),this.multipointEnd.del(),this.pinch.del(),this.swipe.del(),this.tap.del(),this.doubleTap.del(),this.longTap.del(),this.singleTap.del(),this.pressMove.del(),this.twoFingerPressMove.del(),this.touchMove.del(),this.touchEnd.del(),this.touchCancel.del(),this.preV=this.pinchStartLen=this.zoom=this.isDoubleTap=this.delta=this.last=this.now=this.tapTimeout=this.singleTapTimeout=this.longTapTimeout=this.swipeTimeout=this.x1=this.x2=this.y1=this.y2=this.preTapPosition=this.rotate=this.touchStart=this.multipointStart=this.multipointEnd=this.pinch=this.swipe=this.tap=this.doubleTap=this.longTap=this.singleTap=this.pressMove=this.touchMove=this.touchEnd=this.touchCancel=this.twoFingerPressMove=null,window.removeEventListener("scroll",this._cancelAllHandler),null}};