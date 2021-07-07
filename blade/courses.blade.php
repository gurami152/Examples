@extends('layouts.app')
@section('content')
    <div class="container-admin">
        @include('layouts.admin.admin')
        <div class="card-container">
            <div class="card-admin card">
                <div class="card-header">
                    <h1>Курси</h1>
                </div>
                <div class="card-body">
                    <universal-table
                        :search_path="'/api/course?page='"
                        :delete_path="'/api/course/'"
                        :list="[
                        'name',
                        'qualification_id'
                        ]"
                        :show_add_button="true"
                        :show_global_delete_button="true"
                        :selectable="true"
                        :actions_col="true">
                    <course-buttons slot-scope="item" v-bind:item="item"></course-buttons>
                    <course-edit slot="control-add-button" slot-scope="item" v-bind:item="item" v-bind:qualifications="{{json_encode($qualification)}}"></course-edit>
                    </universal-table>
                </div>
            </div>
        </div>
    </div>
@endsection
