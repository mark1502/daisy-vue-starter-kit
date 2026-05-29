<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { activeStyle, navJustify, navItems } from '@/navigation'

// mode: 'horizontal' (desktop bar) | 'menu' (mobile daisyUI dropdown menu)
const props = defineProps({
    mode: {
        type: String,
        default: 'horizontal',
        validator: (v) => ['horizontal', 'menu'].includes(v),
    },
})

const page = usePage()

// Dev-only sanity check: every link needs a usable label. The label is the link's
// accessible name (and, for icon-only links, the tooltip text), so a missing or
// whitespace-only label produces an unreachable / unnamed link. No-op in prod.
if (import.meta.env.DEV) {
    for (const item of navItems) {
        if (!item.label || !item.label.trim()) {
            console.warn(
                `[NavLinks] nav item for route "${item.route}" has a missing or ` +
                    `whitespace-only label. A label is required — it is the link's ` +
                    `accessible name${item.iconOnly ? ' and its tooltip text.' : '.'}`,
            )
        }
    }
}

// Visible items: drop disabled rows and rows whose `show(props)` predicate is falsy.
const visibleItems = computed(() =>
    navItems.filter(
        (item) =>
            item.enabled !== false &&
            (typeof item.show !== 'function' || item.show(page.props)),
    ),
)

// Desktop only: bucket items into start / center / end segments.
const grouped = computed(() => {
    const groups = { start: [], center: [], end: [] }
    for (const item of visibleItems.value) {
        const key = ['start', 'center', 'end'].includes(item.group) ? item.group : 'start'
        groups[key].push(item)
    }
    return groups
})

// active-style -> class lookups
const horizontalBase = {
    daisy: 'btn btn-ghost btn-sm',
    underline:
        'inline-flex items-center gap-1.5 px-1 pb-1 text-sm font-medium border-b-2 border-transparent hover:text-primary transition-colors',
    pill: 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium hover:bg-base-200 transition-colors',
}
const horizontalActive = {
    daisy: 'btn-active',
    underline: 'border-primary text-primary',
    pill: 'bg-primary text-primary-content',
}
const menuActive = {
    daisy: 'menu-active',
    underline: 'text-primary font-medium',
    pill: 'bg-primary text-primary-content font-medium',
}

const justifyMap = {
    between: 'justify-between',
    start: 'justify-start',
    center: 'justify-center',
    end: 'justify-end',
    around: 'justify-around',
}
const justifyClass = computed(() => justifyMap[navJustify] ?? justifyMap.between)

// Active when Ziggy's current route matches the item's `active` pattern
// (falls back to its `route` name). Supports wildcards, e.g. 'reports.*'.
const isActive = (item) => route().current(item.active ?? item.route)

// --- Icons -----------------------------------------------------------------
// An item's `icon` is either a string (image path -> <img>) or a component
// (e.g. a lucide icon -> <component :is>). Default lucide render size for the bar.
const iconSize = 18
const isImageIcon = (icon) => typeof icon === 'string'

// Whether the text label is shown. `iconOnly` only applies to the desktop bar;
// the stacked mobile menu always shows labels (icon-only rows are unreadable there).
const showLabel = (item) => props.mode === 'menu' || !item.iconOnly

// Desktop-bar tooltip text (the daisyUI hover bubble; never used in the mobile menu).
//   - not iconOnly: a bubble only if the item declares a `tooltip`.
//   - iconOnly:     defaults to the label; an explicit `tooltip` is appended after
//                   an em dash, e.g. "Home — Go to your homepage".
// The accessible name (aria-label) stays the bare label — the appended text is visual.
const tipText = (item) => {
    if (props.mode === 'menu') return null
    if (item.iconOnly) {
        return item.tooltip ? `${item.label} — ${item.tooltip}` : item.label
    }
    return item.tooltip ?? null
}

const linkClass = (item) => {
    const reverse = item.iconPosition === 'right' ? 'flex-row-reverse' : ''
    if (props.mode === 'menu') {
        return [isActive(item) ? menuActive[activeStyle] : '', reverse, item.class]
    }
    // Any desktop link with tooltip text (explicit, or the icon-only label) gets the
    // daisyUI tooltip classes so the bubble renders on hover.
    const tooltip = tipText(item) ? 'tooltip tooltip-bottom' : ''
    return [
        horizontalBase[activeStyle],
        isActive(item) ? horizontalActive[activeStyle] : '',
        reverse,
        tooltip,
        item.class,
    ]
}
</script>

<template>
    <!-- Mobile / dropdown: stacked daisyUI menu. Groups & justify are ignored here. -->
    <ul v-if="mode === 'menu'" class="menu menu-sm">
        <li v-for="item in visibleItems" :key="item.route">
            <Link :href="route(item.route)" :class="linkClass(item)">
                <component
                    :is="item.icon"
                    v-if="item.icon && !isImageIcon(item.icon)"
                    :size="iconSize"
                />
                <img
                    v-else-if="item.icon"
                    :src="item.icon"
                    alt=""
                    class="h-5 w-5 object-contain"
                />
                <span>{{ item.label }}</span>
            </Link>
        </li>
    </ul>

    <!-- Desktop: single flex row; each populated group renders as a segment. -->
    <nav v-else class="flex w-full items-center gap-1" :class="justifyClass">
        <div
            v-for="key in ['start', 'center', 'end']"
            v-show="grouped[key].length"
            :key="key"
            class="flex items-center gap-1"
        >
            <Link
                v-for="item in grouped[key]"
                :key="item.route"
                :href="route(item.route)"
                :class="linkClass(item)"
                :data-tip="tipText(item)"
                :aria-label="showLabel(item) ? null : item.label"
            >
                <component
                    :is="item.icon"
                    v-if="item.icon && !isImageIcon(item.icon)"
                    :size="iconSize"
                />
                <img
                    v-else-if="item.icon"
                    :src="item.icon"
                    :alt="showLabel(item) ? '' : item.label"
                    class="h-5 w-5 object-contain"
                />
                <span v-if="showLabel(item)">{{ item.label }}</span>
            </Link>
        </div>
    </nav>
</template>
