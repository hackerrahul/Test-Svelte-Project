<script>
    import "$lib/css/app.css"
    import { onMount } from "svelte";

    import { page } from '$app/stores'
    import { goto } from "$app/navigation";

    export let data;

 
onMount(async () => {
  console.log("App Page", data);

});

</script>

<nav>
    <a href="/app">Main</a>
    
    <form action="/logout" method="POST">
        <button type="submit">Log out</button>
    </form>
  
</nav>

App Page

{data.user.name}