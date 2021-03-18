<template>
    <div>
        <p>Patient id: {{ id }}</p>
        <form @submit.prevent="onSubmit($event)">
            <div class="form-group row">
                <label for="batchno" class="col-sm-2 col-form-label">BATCH NO</label>
                <div class="col-sm-2">
                    <input id="batchno" v-model="vacine.batchno" />
                </div>
                <div class="col-sm-8 float-left text-danger" v-if="errors.batchno">
                    {{ errors.batchno[0].replace("batchno", "BATCH NO") }}
                </div>
            </div>

            <div class="form-group row">
                <label for="batchno" class="col-sm-2 col-form-label">VACINE SERIAL NO</label>
                <div class="col-sm-2">
                    <input id="batchno" v-model="vacine.vialserialno" />
                </div>
                <div class="col-sm-8 float-left text-danger" v-if="errors.vialserialno">
                    {{ errors.vialserialno[0].replace("vialserialno", "VACINE SERIAL NO") }}
                </div>
            </div>

            <div class="form-group" >
            <button :disabled="saving" type="submit" class="btn btn-primary">{{action}}</button>
        </div>
        </form>
    </div>
</template>
<script>
export default {
    props: {
        id: Number,
    },
    data() {
        return {
            action: "Add Vacine",
            vacine: {
                batchno: "",
                vialserialno: "",
            },
            errors: {}
        }
    }
}
</script>