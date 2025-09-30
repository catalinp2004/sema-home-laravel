<template>
	<div class="text-white p-4 snipped card-panel">
		<fieldset class="mb-0">
			<ul class="list-unstyled mb-0 d-grid gap-2">
				<li v-for="opt in options" :key="opt.value" class="d-flex align-items-center">
					<label class="d-flex align-items-center gap-2 w-100">
						<input type="radio"
							class="form-check-input"
							name="rooms"
							:value="String(opt.value)"
							:checked="String(modelValue) === String(opt.value)"
							@change="onChange(opt.value)" />
						<span class="label-text">{{ opt.label }}</span>
					</label>
				</li>
			</ul>
		</fieldset>
	</div>
  
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
	modelValue: { type: [String, Number], default: 'toate' },
});

const emit = defineEmits(['update:modelValue', 'change']);

const options = computed(() => ([
	{ label: 'Toate', value: 'toate' },
	{ label: 'O cameră', value: 1 },
	{ label: '2 camere', value: 2 },
	{ label: '3 camere', value: 3 },
	{ label: '4 camere', value: 4 },
]));

function onChange(val) {
	// normalize to string so direct queryparams (e.g. '1') match option values
	const s = String(val);
	emit('update:modelValue', s);
	emit('change', s);
}
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