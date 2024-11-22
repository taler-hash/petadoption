<template>
    <div class="w-full bg-zinc-700 max-h-[24rem] p-2 flex justify-center">
        <div class="max-w-7xl h-full space-y-4 flex flex-col items-center py-10">
            <img :src="Logo" alt="" class="w-40 h-20 object-contain">
            <div class="font-bold text-center text-white">
                <p class="">PAWPRINTS: INTEGRATED SOLUTION FOR</p>
                <p> ANIMAL WELFARE AND ADOPTION SERVICES</p>
            </div>
            
        </div>
    </div>
</template>
<script setup lang="ts">
import Logo from '@/assets/logo.png'
</script>