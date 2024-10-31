const settings = window.wc.wcSettings.getSetting( 'payl8r_data', {} );
const label = window.wp.htmlEntities.decodeEntities( settings.title ) || window.wp.i18n.__( 'Payl8r Gateway', 'payl8r_gateway' );
const Content = () => {
    return window.wp.htmlEntities.decodeEntities( settings.description || '' );
};

const htmlToElem = ( html ) => wp.element.RawHTML( { children: html } );

const Block_Gateway = {
    name: 'payl8r',
    label: label,
    content: htmlToElem(settings.description),
    edit: htmlToElem(settings.description),
    canMakePayment: () => true,
    ariaLabel: label,
    supports: {
        features: settings.supports,
    },
};

window.wc.wcBlocksRegistry.registerPaymentMethod( Block_Gateway );