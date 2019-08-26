<template>
    <div>
        <toolbar></toolbar>
        <router-view :key="$route.fullPath"></router-view>
        <Loader></Loader>
        <app-footer></app-footer>
    </div>
</template>

<script>
import toolbar from './Toolbar';
import AppFooter from './AppFooter';
import Login from './login/Login';
import Loader from './Loader';
export default {
    components : {toolbar, AppFooter, Login, Loader}
}
</script>

<style>

</style>
