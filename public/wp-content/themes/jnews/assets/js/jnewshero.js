!function(){"use strict";window.jnews=window.jnews||{},window.jnews.hero=window.jnews.hero||{};var e="object"==typeof jnews&&"object"==typeof jnews.library,n="function"==typeof jnews.tns,t=!1;window.jnews.hero={action:function(){var e=this;t&&e.jnewsLibrary.cancelAnimationFrame.call(e.jnewsLibrary.win,t),t=e.jnewsLibrary.requestAnimationFrame.call(e.jnewsLibrary.win,(function(){e.dispatch(),e.heroSlider(e.container)}))},init:function(n){var t=this;if(t.jnewsLibrary=!!e&&jnews.library,t.jnewsLibrary){t.container=void 0===n?t.jnewsLibrary.globalBody:n;var r={resize:t.action.bind(this)};t.jnewsLibrary.winLoad(t.action.bind(this)),t.jnewsLibrary.docReady(t.action.bind(this)),t.jnewsLibrary.addEvents(t.jnewsLibrary.win,r)}},dispatch:function(){var e=this;e.jnewsLibrary.forEach(e.container.getElementsByClassName("jeg_heroblock"),(function(n,t){var r=n,a=r.getElementsByClassName("jeg_heroblock_wrapper"),s=r.getElementsByClassName("jeg_heroblock_scroller"),i=r.getElementsByClassName("jeg_post"),o=r.dataset.margin;e.jnewsLibrary.windowWidth()>667?(a.length>0&&e.jnewsLibrary.forEach(a,(function(e,n){e.style.marginLeft="-"+o+"px",e.style.marginBottom="-"+o+"px",e.style.marginRight=0,e.style.marginTop=0})),i.length>0&&e.jnewsLibrary.forEach(i,(function(e,n){e.style.padding="0 0 "+o+"px "+o+"px "}))):s.length>0&&(o>5&&(o=5),e.jnewsLibrary.hasClass(r,"tiny-slider")||e.jnewsLibrary.forEach(s,(function(e,n){e.style.marginLeft="-"+o+"px"})),a.length>0&&e.jnewsLibrary.forEach(a,(function(e,n){e.style.marginLeft=0,e.style.marginBottom=0,e.style.marginRight=0})),i.length>0&&e.jnewsLibrary.forEach(i,(function(n,t){e.jnewsLibrary.getParents(n,".jeg_heroblock_scroller").length>0?e.jnewsLibrary.hasClass(r,"tiny-slider")?e.jnewsLibrary.hasClass(r,"jeg_heroblock_1")&&e.jnewsLibrary.hasClass(n,"jeg_hero_item_4")||e.jnewsLibrary.hasClass(r,"jeg_heroblock_2")&&(e.jnewsLibrary.hasClass(n,"jeg_hero_item_3")||e.jnewsLibrary.hasClass(n,"jeg_hero_item_5"))||e.jnewsLibrary.hasClass(r,"jeg_heroblock_3")&&(e.jnewsLibrary.hasClass(n,"jeg_hero_item_3")||e.jnewsLibrary.hasClass(n,"jeg_hero_item_4"))||e.jnewsLibrary.hasClass(r,"jeg_heroblock_4")&&e.jnewsLibrary.hasClass(n,"jeg_hero_item_3")?(n.style.paddingLeft=o+"px",n.style.paddingBottom=o+"px"):(n.style.paddingLeft=0,n.style.paddingBottom=o+"px"):(n.style.paddingLeft=o+"px",n.style.paddingBottom=0):(n.style.paddingLeft=0,n.style.paddingBottom=o+"px")})))}))},heroSlider:function(e){if(n){var t=this,r=e.querySelectorAll(".jeg_heroblock.tiny-slider");r.length>0&&t.jnewsLibrary.forEach(r,(function(e,n){var r=e,a=r.dataset.autoplay,s=r.dataset.delay,i=!1;i="undefined"!=typeof jnewsoption?1==jnewsoption.rtl:"undefined"!=typeof jnewsgutenbergoption&&1==jnewsgutenbergoption.rtl,r=r.querySelectorAll(".jeg_hero_wrapper:not(.jeg_tns_active)"),t.jnewsLibrary.forEach(r,(function(e,n){if(!t.jnewsLibrary.hasClass(e,"jeg_tns_active")){var r=jnews.tns({container:e,textDirection:i?"rtl":"ltr",items:1,controlsText:["",""],controls:!0,nav:!1,loop:!0,autoplay:a,autoplayTimeout:s,mouseDrag:!0,onInit:function(e){void 0!==e.nextButton&&t.jnewsLibrary.addClass(e.nextButton,"tns-next"),void 0!==e.prevButton&&t.jnewsLibrary.addClass(e.prevButton,"tns-prev")}});void 0!==r&&(r.events.on("dragStart",(function(e){e.event.preventDefault(),e.event.stopPropagation()})),t.jnewsLibrary.addClass(e,"jeg_tns_active"),t.jnewsLibrary.dataStorage.put(e,"tiny-slider",r))}}))}))}}}}();