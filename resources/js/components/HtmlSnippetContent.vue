<template>
    <div>
        <div class="w-full flex pl-2 mt-2 text-left">
            <div class="w-5/6">
                <label class="block text-md font-medium text-gray-700">Description</label>
                <div class="container">{{ snippet.data.attributes.description }}</div>
            </div>
            <div class="w-1/6 flex justify-end">
                <custom-button buttonClass="pt-1 w-1/3 h-2/3 mr-3 text-white rounded p-1  bg-gray-400"  @click="copyHtmlSnippet">
                    <custom-icon name="copy" width="1rem" height="1rem"/>
                </custom-button>

            </div>
        </div>
        <div class="w-full pl-2 mt-2 text-left overflow-scroll h-72">
            <label class="block text-md font-medium text-gray-700">Html Snippet</label>
            <div id="htmlSnippet"
                 class="container p-1 h-4/5 border-solid border-gray-800 border-2 overflow-y-scroll bg-gray-200">
                {{ snippet.data.attributes.html }}
            </div>

        </div>
    </div>
</template>

<script>

import CustomButton from './CustomButton'
import EventBus from '../event-bus'
import CustomIcon from './CustomIcon'
export default {
    name: 'HtmlSnippetContent',
    props: {
        snippet: {
            type: Object,
            required: true
        }
    },
    components: {
        CustomButton,
        CustomIcon
    },
    methods: {
        copyHtmlSnippet () {
            navigator.clipboard.writeText(document.getElementById('htmlSnippet').textContent)
            EventBus.$emit('notify', 'Copied to clipboard.', 'info')
        }
    }
}
</script>

<style scoped>

</style>