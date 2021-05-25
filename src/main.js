import 'vite/dynamic-import-polyfill';
import axios from 'axios'

axios('https://goodmotion.fr').then((r) => console.log(r))

console.log('hello world')
