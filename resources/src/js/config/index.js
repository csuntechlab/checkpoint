// Checkpoint global config
// Reference: resources/views/pages/index.blade.php

const metaTags = document.getElementsByTagName('meta');

export default {
    url: metaTags['check-url'].content,
    token: metaTags['csrf-token'].content,
};
