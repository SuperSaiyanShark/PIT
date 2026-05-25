import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        // =========================================================================
        // MODULE INTERCEPTOR: Handle explicit Module name-spacing (e.g. "Module4::Dashboard")
        // =========================================================================
        if (name.includes('::')) {
            const [module, page] = name.split('::');
            
            // Map the lookup directly into the isolated subfolder system inside your plugin
            const modulePages = import.meta.glob('../../Modules/*/resources/assets/js/Pages/**/*.jsx');
            const targetModulePath = `../../Modules/${module}/resources/assets/js/Pages/${page}.jsx`;
            
            if (!modulePages[targetModulePath]) {
                throw new Error(`Inertia Page component not found inside ${module}: ${page}.jsx at target path: ${targetModulePath}`);
            }
            
            return resolvePageComponent(targetModulePath, modulePages);
        }

        // =========================================================================
        // STANDARD ROOT APP LOOKUP: Preserves all your original normalization rules
        // =========================================================================
        // 1. Gather all available .jsx pages across your entire root directory structure
        const pages = import.meta.glob('./Pages/**/*.jsx');

        // 2. Normalize common folder names and case variations up-front
        let normalizedName = name;
        
        if (name.startsWith('Wards/')) {
            normalizedName = name.replace('Wards/', 'WardManagement/');
        } else if (name.startsWith('wards/')) {
            normalizedName = name.replace('wards/', 'WardManagement/');
        } else if (name.startsWith('Staff-roles/') || name.startsWith('staff-roles/')) {
            normalizedName = normalizedName.replace(/staff-roles\//i, 'StaffRoles/');
        } else if (name.startsWith('StaffRoles/') || name.startsWith('staffroles/')) {
            normalizedName = normalizedName.replace(/staffroles\//i, 'StaffRoles/');
        }

        // Standardize the first folder segment to be capitalized (e.g., "schedules/Create" -> "Schedules/Create")
        if (normalizedName.includes('/')) {
            const parts = normalizedName.split('/');
            parts[0] = parts[0].charAt(0).toUpperCase() + parts[0].slice(1);
            normalizedName = parts.join('/');
        } else {
            normalizedName = normalizedName.charAt(0).toUpperCase() + normalizedName.slice(1);
        }

        // 3. Build a list of paths where this component could live
        const structuralPaths = [
            `./Pages/${normalizedName}.jsx`,
            `./Pages/${normalizedName}/Index.jsx`,
            `./Pages/Module3/${normalizedName}.jsx`,
            `./Pages/Module3/${normalizedName}/Index.jsx`
        ];

        // Find the first path that actually exists in your project files
        const finalPath = structuralPaths.find(path => pages[path]);

        if (!finalPath) {
            throw new Error(`Inertia Page component not found for matching patterns: ${name}`);
        }

        // 4. Hand off to Vite's official helper function to ensure hot-reloading works
        return resolvePageComponent(finalPath, pages);
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});