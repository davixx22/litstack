<template>
	<div class="lit-col-relation" v-if="relation">
		{{ format(value, relation) }}
		<a :href="`${Lit.baseURL}${relationLink}/${relation.id}`">
			<lit-fa-icon icon="external-link-alt" />
		</a>
	</div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
	name: 'ColCrudRelation',
	props: {
		item: {
			required: true,
			type: Object,
		},
		related: {
			type: [String],
		},
		value: {
			required: true,
			type: String,
		},
		routePrefix: {
			required: false,
			type: String,
		},
		format: {
			type: Function,
			required: true,
		},
	},
	computed: {
		relation() {
			return this.item[this.related];
		},
		relationLink() {
			if (this.routePrefix) {
				return this.routePrefix;
			}
			return this.relation;
		},
	},
};
</script>

<style lang="scss">
.lit-col-relation {
	> a {
		opacity: 0;
		cursor: pointer !important;
	}

	&:hover {
		> a {
			opacity: 1;
		}
	}
}
</style>
