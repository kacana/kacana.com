/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.baseFloatZIndex = 9000;
    config.toolbar = [
        {name : 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
        {name : 'editing', items: ['Scayt']},
        {name : 'links', items: ['Link', 'Unlink', 'Anchor']},
        {name : 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar']},
        {name: 'tools', items:['Maximize']},
        {name: 'documents', items:['Source']},
        '/',
        {name: 'basicstyles', items:['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']},
        {name: 'paragraph', items:['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
        {name: 'styles', items:['Styles', 'Format']},
        {name: 'about', items:['About']}
    ];
};
