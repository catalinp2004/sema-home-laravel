<template>
	<div class="text-white px-4 py-3 py-lg-4 snipped card-panel">
		<fieldset class="mb-0">
			<ul class="list-unstyled mb-0 row gy-2 flex-lg-column">
				<li v-for="opt in options" :key="opt.value" class="d-flex align-items-center col-6 col-lg-auto">
					<label class="d-flex align-items-center w-100">
						<input type="radio"
							class="form-check-input"
							name="rooms"
							:value="String(opt.value)"
							v-model="rooms" />
						<span class="label-text ms-2">{{ opt.label }}</span>
					</label>
				</li>
			</ul>
		</fieldset>
	</div>
  
</template>

<script setup>
import { computed } from 'vue';

const rooms = defineModel({ type: [String, Number], default: 'toate' });

const options = computed(() => ([
	{ label: 'Toate', value: 'toate' },
	{ label: '1 cameră', value: 1 },
	{ label: '2 camere', value: 2 },
	{ label: '3 camere', value: 3 },
	{ label: '4 camere', value: 4 },
]));
</script>

<style scoped>
.card-panel {
    background-color: rgba(41, 71, 82, .85);
    backdrop-filter: blur(6px);
    box-shadow: 0 3px 17px rgba(41, 71, 82, .56);
}
.label-text { font-weight: 600; }
.form-check-input { width: 1.05rem; height: 1.05rem; cursor: pointer; }
label { cursor: pointer; }
</style>