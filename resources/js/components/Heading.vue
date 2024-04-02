<template>
    <h1 class="mb-4 text-4xl font-extrabold text-white">
        <slot name="category"></slot>
        <span
            class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-500 from-sky-200"
        >
            <slot></slot>
        </span>
    </h1>
</template>
