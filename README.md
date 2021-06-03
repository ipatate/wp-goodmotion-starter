## WP Starter theme

This theme use : 
- Timber [https://upstatement.com/timber/](https://upstatement.com/timber/)
- vite [https://vitejs.dev/](https://vitejs.dev/)
- tailwind V2 [https://tailwindcss.com/](https://tailwindcss.com/)

## Requirement for use this theme

- Timber plugin [https://wordpress.org/plugins/timber-library/](https://wordpress.org/plugins/timber-library/)

## wp-config.js

Define environment variable :

```
define('WP_ENV', 'development'); // or production
```

## development requirement

Use or install node.js on your local machine.  
This project use npm and node for compile assets.

For install dependencies :

```bash
npm install
```


## npm scripts

For start development :
```
npm run dev
```

For build assets:
```
npm run build
```

## Gutenberg editor

For admin editor, a css file is generated on build.  
Use the ```assets/css/editor.css``` file for add style.

The command is run on build but you can generate separately:

```
npm run build:editor
```
or
```
npm run watch:editor
```



## assets in CSS

use ```/assets/image.jpg``` instead of ```./assets/image.jpg```

Vite add a base path to asset on build.
