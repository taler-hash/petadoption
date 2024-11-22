import { definePreset } from "@primevue/themes";
import Aura from '@primevue/themes/aura';

export const AdoptionPresets = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{lime.50}',
            100: '{lime.100}',
            200: '{lime.200}',
            300: '{lime.300}',
            400: '{lime.400}',
            500: '{lime.500}',
            600: '{lime.600}',
            700: '{lime.700}',
            800: '{lime.800}',
            900: '{lime.900}',
            950: '{lime.950}'
        },
        colorScheme: {
            light: {
                primary: {
                    color: '{lime.950}',
                    inverseColor: '#ffffff',
                    hoverColor: '{lime.900}',
                    activeColor: '{lime.800}'
                },
                highlight: {
                    background: '{lime.950}',
                    focusBackground: '{lime.700}',
                    color: '#ffffff',
                    focusColor: '#ffffff'
                }
            },
            dark: {
                primary: {
                    color: '{lime.50}',
                    inverseColor: '{lime.950}',
                    hoverColor: '{lime.100}',
                    activeColor: '{lime.200}'
                },
                highlight: {
                    background: 'rgba(250, 250, 250, .16)',
                    focusBackground: 'rgba(250, 250, 250, .24)',
                    color: 'rgba(255,255,255,.87)',
                    focusColor: 'rgba(255,255,255,.87)'
                }
            }
        }
    }
});
