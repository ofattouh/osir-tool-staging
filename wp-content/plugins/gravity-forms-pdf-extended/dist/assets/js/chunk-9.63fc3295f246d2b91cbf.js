(window.webpackJsonp=window.webpackJsonp||[]).push([[9],{276:function(e,t,r){"use strict";r.r(t);r(31),r(38),r(39),r(57),r(58),r(82),r(48),r(32),r(252),r(100),r(71),r(93),r(94),r(80),r(91),r(18),r(81),r(41),r(29),r(21),r(152),r(83),r(40);var n=r(0),a=r.n(n),o=r(254),c=r.n(o),i=r(270),l=r(273),u=r(277),s=r(271),f=(r(33),r(153),r(1)),h=function(e){var t=e.groups;return a.a.createElement("div",{className:"search-result"},Object.entries(t).map((function(e,t){return a.a.createElement("section",{className:"group-section",key:t},a.a.createElement("div",{className:"group-name"},e[0]),a.a.createElement("ul",{className:"search-menu"},e[1].map((function(e,t){var r=e[1],n=e[2],o=(e[0].lvl2?e[0].lvl2:"")+(e[0].lvl3?" - "+e[0].lvl3:""),c=n?n.substr(0,80)+"...":o;return a.a.createElement("li",{key:t},a.a.createElement("a",{href:r},a.a.createElement("div",{className:"hit-container"},a.a.createElement("div",{className:"hit-icon"},a.a.createElement("svg",{width:"20",height:"20",viewBox:"0 0 20 20"},a.a.createElement("path",{d:"M17 6v12c0 .52-.2 1-1 1H4c-.7 0-1-.33-1-1V2c0-.55.42-1 1-1h8l5 5zM14 8h-3.13c-.51 0-.87-.34-.87-.87V4",stroke:"currentColor",fill:"none",fillRule:"evenodd",strokeLinejoin:"round"}))),a.a.createElement("div",{className:"hit-content-wrapper"},a.a.createElement("span",{className:"hit-title",dangerouslySetInnerHTML:{__html:e[0].lvl1}}),a.a.createElement("span",{className:"hit-path",dangerouslySetInnerHTML:{__html:c}})),a.a.createElement("div",{className:"hit-action"},a.a.createElement("svg",{className:"DocSearch-Hit-Select-Icon",width:"20",height:"20",viewBox:"0 0 20 20"},a.a.createElement("g",{stroke:"currentColor",fill:"none",fillRule:"evenodd",strokeLinecap:"round",strokeLinejoin:"round"},a.a.createElement("path",{d:"M18 3v4c0 2-2 4-4 4H2"}),a.a.createElement("path",{d:"M8 17l-6-6 6-6"})))))))}))))})))};h.propTypes={groups:r.n(f).a.object.isRequired};var p=h;function y(e){return(y="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function m(e){return function(e){if(Array.isArray(e))return v(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return v(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return v(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function v(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}function b(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function d(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?b(Object(r),!0).forEach((function(t){T(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):b(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function g(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function O(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function w(e,t){return(w=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function E(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var r,n=S(e);if(t){var a=S(this).constructor;r=Reflect.construct(n,arguments,a)}else r=n.apply(this,arguments);return j(this,r)}}function j(e,t){return!t||"object"!==y(t)&&"function"!=typeof t?P(e):t}function P(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}function S(e){return(S=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}function T(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}
/**
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2021, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       5.2
 */r.d(t,"HelpContainer",(function(){return k}));var k=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&w(e,t)}(f,e);var t,r,n,o=E(f);function f(){var e;g(this,f);for(var t=arguments.length,r=new Array(t),n=0;n<t;n++)r[n]=arguments[n];return T(P(e=o.call.apply(o,[this].concat(r))),"onHandleHit",(function(e){var t=e.hits.reduce((function(e,t){return d({},e,T({},t.hierarchy.lvl0,[].concat(m(e[t.hierarchy.lvl0]||[]),[[t.hierarchy,t.url,t.content]])))}),{});return a.a.createElement(p,{groups:t})})),e}return t=f,(r=[{key:"render",value:function(){var e=c()("BH4D9OD16A","3f8f81a078907e98ed8d3a5bedc3c61c"),t={search:function(t){if(""!==t[0].params.query)return e.search(t)}},r=Object(i.a)(this.onHandleHit);return a.a.createElement(l.a,{searchClient:t,indexName:"gravitypdf"},a.a.createElement(u.a,{facetFilters:["version:v6"],highlightPreTag:"<mark>",highlightPostTag:"</mark>",attributesToRetrieve:["hierarchy.lvl0","hierarchy.lvl1","hierarchy.lvl2","hierarchy.lvl3","hierarchy.lvl4","hierarchy.lvl5","hierarchy.lvl6","content","type","url"],attributesToSnippet:["hierarchy.lvl1:5","hierarchy.lvl2:5","hierarchy.lvl3:5","hierarchy.lvl4:5","hierarchy.lvl5:5","hierarchy.lvl6:5","content:5"],snippetEllipsisText:"…"}),a.a.createElement(s.a,{translations:{submitTitle:GFPDF.searchBoxSubmitTitle,resetTitle:GFPDF.searchBoxResetTitle,placeholder:GFPDF.searchBoxPlaceHolderText},autofocus:!0}),a.a.createElement(r,null))}}])&&O(t.prototype,r),n&&O(t,n),f}(n.Component);t.default=k}}]);