---
name: Clinical Precision
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#424752'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#727783'
  outline-variant: '#c2c6d4'
  surface-tint: '#005db6'
  primary: '#00478d'
  on-primary: '#ffffff'
  primary-container: '#005eb8'
  on-primary-container: '#c8daff'
  inverse-primary: '#a9c7ff'
  secondary: '#006a63'
  on-secondary: '#ffffff'
  secondary-container: '#79f3e7'
  on-secondary-container: '#006f67'
  tertiary: '#43484c'
  on-tertiary: '#ffffff'
  tertiary-container: '#5b6063'
  on-tertiary-container: '#d6dade'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d6e3ff'
  primary-fixed-dim: '#a9c7ff'
  on-primary-fixed: '#001b3d'
  on-primary-fixed-variant: '#00468c'
  secondary-fixed: '#7cf6ea'
  secondary-fixed-dim: '#5ddacd'
  on-secondary-fixed: '#00201d'
  on-secondary-fixed-variant: '#00504a'
  tertiary-fixed: '#dfe3e7'
  tertiary-fixed-dim: '#c3c7cb'
  on-tertiary-fixed: '#171c1f'
  on-tertiary-fixed-variant: '#43474b'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  headline-xl:
    fontFamily: Plus Jakarta Sans
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 36px
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  xs: 4px
  sm: 12px
  md: 24px
  lg: 48px
  xl: 80px
  container-max: 1280px
  gutter: 24px
---

## Brand & Style
The design system is anchored in the intersection of clinical excellence and digital accessibility. The brand personality is professional and empathetic, designed to reduce patient anxiety through a high-efficiency interface that feels both technologically advanced and human-centric.

The visual style follows a **Corporate / Modern** aesthetic with heavy influences from **Minimalism**. It prioritizes extreme legibility, intentional whitespace, and a structured information hierarchy. The interface avoids unnecessary decorative elements, favoring clarity and high-contrast accessibility to ensure patients of all technical literacies can navigate their healthcare journey with confidence.

## Colors
The palette is rooted in "Medical Blue," a color psychologically associated with trust and stability. The "Health Teal" secondary color is used exclusively for health-related actions, progress indicators, and subtle accents to differentiate clinical data from administrative UI.

Surface colors utilize a tiered light-gray system to create a "sterile but warm" environment. High-contrast ratios (minimum 4.5:1) are maintained for all text elements against their respective backgrounds to meet WCAG AA standards.

## Typography
This design system employs a dual-font strategy. **Plus Jakarta Sans** is used for headlines to provide a friendly, slightly rounded, and modern character. **Inter** is used for all body copy and functional labels due to its exceptional legibility in data-dense clinical environments.

Hierarchy is established through significant weight shifts. Large headlines use tighter letter spacing to maintain a "contained" and professional look, while labels utilize uppercase styling and slight tracking for quick scanning of status indicators and metadata.

## Layout & Spacing
The layout follows a **Fixed Grid** model on desktop (12 columns) and a **Fluid Grid** on mobile (4 columns). A strict 8px base unit (linear scale) governs all padding and margins to ensure visual rhythm.

Generous whitespace is mandated between distinct sections (using the `lg` and `xl` tokens) to prevent cognitive overload. On mobile, margins are reduced to 16px, but vertical spacing between "cards" remains at 24px to maintain a sense of openness and breathing room.

## Elevation & Depth
Depth is communicated through **Ambient Shadows** and **Tonal Layers**. This design system avoids harsh borders, preferring soft, diffused shadows to lift interactive elements from the background.

- **Level 0 (Flat):** Main background surface (#F8FAFC).
- **Level 1 (Surface):** Default card state. White background with a 1px border (#E2E8F0).
- **Level 2 (Raised):** Hover states and active appointment cards. Utilizes a soft shadow: `0px 4px 12px rgba(0, 94, 184, 0.08)`.
- **Level 3 (Overlay):** Modals and dropdowns. `0px 12px 32px rgba(0, 0, 0, 0.1)`.

Tinted shadows (using a percentage of the Primary Blue) are used on primary buttons and active states to reinforce brand identity through depth.

## Shapes
The shape language is "Soft-Modern." All primary containers, including cards and input fields, use an **8px (0.5rem)** radius. Large elements like hero sections or promotional banners may use the **16px (1rem)** radius for a more welcoming, approachable feel.

Status indicators and badges use a **Pill-shaped** radius (full rounding) to clearly distinguish them from interactive buttons or navigational elements.

## Components

### Status Indicators
- **Online:** Pill-shaped badge with a `success_color` dot and 10% opacity background of the same color.
- **Offline/Busy:** Pill-shaped badge with a `neutral_color` dot.
- **Waiting Room:** Pill-shaped badge using `warning_color` to indicate a state of transition.

### Appointment Cards
Cards should use a Level 1 elevation with a Primary Blue left-border accent (4px width) to denote clinical priority. Use `headline-md` for the specialist name and `body-sm` for the timestamp.

### Buttons
- **Primary:** Solid `primary_color` with white text. 8px corner radius.
- **Secondary:** Transparent background with `primary_color` 2px border.
- **Health Action:** Solid `secondary_color` (Teal) for actions specifically related to health records or starting a consultation.

### Specialist Badges
Small, circular avatars (40px) accompanied by a `label-sm` tag indicating their department (e.g., "Cardiology"). These tags should use a light gray background to remain secondary to the name.

### Input Fields
Fields must have a clear 1px border. On focus, the border transitions to `primary_color` with a subtle 3px outer glow (Primary Blue at 10% opacity). Labels always remain visible above the field for accessibility.