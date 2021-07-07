<template>
    <ul class="nav nav-tabs">
        <li ref="carousel" class="nav-item">
            <a id="University-tab" :class="{'active': currentStep === 'universityPage'}" class="nav-link"
               v-on:click.prevent="goToStep('universityPage')">Оберіть Університет</a>
        </li>
        <li v-if="registrationFields.statementField" ref="carousel" class="nav-item">
            <a id="statement-tab"
               :class="{'disabled': !list.includes('statementPage'), 'active':currentStep === 'statementPage'}"
               class="nav-link"
               v-on:click.prevent="goToStep('statementPage')">Заява</a>
        </li>
        <li class="nav-item">
            <a id="personalData-tab"
               :class="{'disabled': !list.includes('personalPage'), 'active':currentStep === 'personalPage'}"
               class="nav-link"
               v-on:click.prevent="goToStep('personalPage')">Особові дані</a>
        </li>
        <li ref="carousel" class="nav-item">
            <a id="passportData-tab"
               :class="{'disabled': !list.includes('passportPage'), 'active':currentStep === 'passportPage'}"
               class="nav-link"
               v-on:click.prevent="goToStep('passportPage')">Паспортні дані</a>
        </li>
        <li v-if="registrationFields.roomsPage" ref="carousel" class="nav-item">
            <a id="selectRoom-tab"
               :class="{'disabled': !list.includes('roomPage'), 'active':currentStep === 'roomPage'}"
               class="nav-link"
               v-on:click.prevent="goToStep('roomPage')">Вибір кімнат</a>
        </li>
        <li ref="carousel" class="nav-item">
            <a id="address-tab"
               :class="{'disabled': !list.includes('addressPage'), 'active':currentStep === 'addressPage'}"
               class="nav-link"
               v-on:click.prevent="goToStep('addressPage')">Адреса</a>
        </li>
        <li v-if="registrationFields.familyPage" ref="carousel" class="nav-item">
            <a id="familyMembers-tab"
               :class="{'disabled': !list.includes('familyPage'), 'active':currentStep === 'familyPage'}"
               class="nav-link"
               v-on:click.prevent="goToStep('familyPage')">Члени родини</a>
        </li>
        <li ref="carousel" class="nav-item">
            <a id="certificate-tab"
               :class="{'disabled': !list.includes('certificatePage'), 'active':currentStep === 'certificatePage'}"
               class="nav-link"
               v-on:click.prevent="goToStep('certificatePage')">Довідки</a>
        </li>
    </ul>
</template>

<script>
export default {
    name: "navigation",
    props: [
        'list',
        'currentStep',
        'registrationFields'
    ],
    methods: {
        goToStep(value) {
            this.$emit('goto', value)
        }
    },
}
</script>

<style scoped>

</style>
