import './bootstrap.ts';

import type { Alpine as AlpineType } from 'alpinejs';

declare global {
  interface Window {
    Alpine: AlpineType;
  }
}
