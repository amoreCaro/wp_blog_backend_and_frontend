/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/components/readMoreBtn.js"
/*!******************************************!*\
  !*** ./src/js/components/readMoreBtn.js ***!
  \******************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   initReadMore: () => (/* binding */ initReadMore)\n/* harmony export */ });\nfunction initReadMore() {\n    // Шукаємо всі блоки \"Read More\" за їхнім базовим класом БЕМ\n    const blocks = document.querySelectorAll('.read-more-block');\n\n    blocks.forEach(block => {\n        const btn = block.querySelector('.read-more-block__btn');\n        const wrapper = block.querySelector('.read-more-block__content-wrapper');\n        const overlay = block.querySelector('.read-more-block__overlay');\n        const textHolder = block.querySelector('.read-more-block__text');\n\n        if (!btn || !wrapper || !textHolder) return;\n\n        btn.addEventListener('click', function() {\n            // Перевірка стану (160px — це початковий стан)\n            const isCollapsed = wrapper.style.maxHeight === '160px' || wrapper.style.maxHeight === '';\n\n            if (isCollapsed) {\n                // Розгортаємо: встановлюємо висоту відповідно до scrollHeight внутрішнього тексту\n                wrapper.style.maxHeight = textHolder.scrollHeight + \"px\";\n                if (overlay) overlay.style.opacity = '0';\n                this.textContent = 'Show Less';\n            } else {\n                // Згортаємо\n                wrapper.style.maxHeight = '160px';\n                if (overlay) overlay.style.opacity = '1';\n                this.textContent = 'Read More';\n                \n                // Скролимо до початку блоку, щоб контент не \"стрибнув\" з-під очей\n                block.scrollIntoView({ behavior: 'smooth', block: 'nearest' });\n            }\n        });\n    });\n}\n\n//# sourceURL=webpack:///./src/js/components/readMoreBtn.js?\n}");

/***/ },

/***/ "./src/js/main.js"
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _components_readMoreBtn_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/readMoreBtn.js */ \"./src/js/components/readMoreBtn.js\");\n\n\ndocument.addEventListener('DOMContentLoaded', function() {\n  console.log(\"Main js loaded\")\n  ;(0,_components_readMoreBtn_js__WEBPACK_IMPORTED_MODULE_0__.initReadMore)();\n});\n\n//# sourceURL=webpack:///./src/js/main.js?\n}");

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Check if module exists (development only)
/******/ 		if (__webpack_modules__[moduleId] === undefined) {
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/js/main.js");
/******/ 	
/******/ })()
;