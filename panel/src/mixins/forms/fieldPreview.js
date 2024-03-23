export default {
	inheritAttrs: false,
	props: {
		column: {
			default: () => ({}),
			type: Object
		},
		field: {
			default: () => ({}),
			type: Object
		},
		value: {}
	},
	computed: {
		isEditable() {
			return this.field.disabled !== true;
		}
	}
};
