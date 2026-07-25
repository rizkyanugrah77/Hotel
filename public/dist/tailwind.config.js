/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './index.html',
    './pages/**/*.html',
    './resources/**/*.{js,html}',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#A61B1B',
          50: '#FDF2F2',
          100: '#FBE5E5',
          200: '#F5BFBF',
          300: '#EF9999',
          400: '#D45A5A',
          500: '#A61B1B',
          600: '#7F1416',
          700: '#5C0F10',
          800: '#3D0A0B',
          900: '#1F0505',
        },
        secondary: {
          DEFAULT: '#7F1416',
          50: '#F9EDED',
          100: '#F3DBDB',
          200: '#E5B0B1',
          300: '#D78687',
          400: '#AB4D4E',
          500: '#7F1416',
          600: '#661012',
          700: '#4D0C0D',
          800: '#330809',
          900: '#1A0404',
        },
        accent: {
          DEFAULT: '#D4AF37',
          50: '#FBF7E8',
          100: '#F7EFD1',
          200: '#EFDFA3',
          300: '#E7CF75',
          400: '#DEBF47',
          500: '#D4AF37',
          600: '#B8952A',
          700: '#8A7020',
          800: '#5C4A15',
          900: '#2E250B',
        },
        background: '#FAFAF9',
        foreground: '#111827',
      },
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
        inter: ['Inter', 'sans-serif'],
      },
      borderRadius: {
        '2xl': '1rem',
        '3xl': '1.5rem',
        '4xl': '2rem',
      },
      boxShadow: {
        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
        'soft-lg': '0 10px 40px -10px rgba(0, 0, 0, 0.1), 0 4px 20px -5px rgba(0, 0, 0, 0.05)',
        'soft-xl': '0 20px 60px -15px rgba(0, 0, 0, 0.12), 0 10px 30px -10px rgba(0, 0, 0, 0.06)',
        'gold': '0 4px 20px -4px rgba(212, 175, 55, 0.3)',
        'red': '0 4px 20px -4px rgba(166, 27, 27, 0.3)',
      },
      animation: {
        'fade-in': 'fadeIn 0.6s ease-out forwards',
        'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
        'fade-in-down': 'fadeInDown 0.5s ease-out forwards',
        'scale-up': 'scaleUp 0.5s ease-out forwards',
        'slide-up': 'slideUp 0.6s ease-out forwards',
        'slide-in-left': 'slideInLeft 0.6s ease-out forwards',
        'slide-in-right': 'slideInRight 0.6s ease-out forwards',
        'float': 'float 6s ease-in-out infinite',
        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
        'shimmer': 'shimmer 2s linear infinite',
        'bounce-soft': 'bounceSoft 2s ease-in-out infinite',
        'spin-slow': 'spin 3s linear infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(30px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeInDown: {
          '0%': { opacity: '0', transform: 'translateY(-20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        scaleUp: {
          '0%': { opacity: '0', transform: 'scale(0.9)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(60px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideInLeft: {
          '0%': { opacity: '0', transform: 'translateX(-40px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        slideInRight: {
          '0%': { opacity: '0', transform: 'translateX(40px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-20px)' },
        },
        pulseSoft: {
          '0%, 100%': { opacity: '1' },
          '50%': { opacity: '0.7' },
        },
        shimmer: {
          '0%': { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' },
        },
        bounceSoft: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-10px)' },
        },
      },
      backgroundImage: {
        'gradient-primary': 'linear-gradient(135deg, #A61B1B 0%, #7F1416 100%)',
        'gradient-accent': 'linear-gradient(135deg, #D4AF37 0%, #B8952A 100%)',
        'gradient-dark': 'linear-gradient(135deg, #1F0505 0%, #3D0A0B 100%)',
        'gradient-hero': 'linear-gradient(135deg, rgba(166,27,27,0.85) 0%, rgba(127,20,22,0.7) 50%, rgba(31,5,5,0.9) 100%)',
      },
    },
  },
  plugins: [],
};
