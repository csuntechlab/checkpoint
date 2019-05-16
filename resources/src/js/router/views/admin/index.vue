<template>
  <main role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container">
          <h1 class="display-3">Build Poder Employee Report</h1>
          <h3>Build by META+Lab</h3>
          <h3>View your dashboard below for details regarding your Scholars, Mentors, and Timesheets</h3>
        </div>
      </div>

      <div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-12">
            <h2>Programs</h2>
            <p>Here you can find your programs, their associated mentors, and students.</p>
            <p><router-link class="btn btn-secondary" to="/programs" role="button">View details »</router-link></p>
          </div>
          <div class="col-md-12">
            <h2>Mentors</h2>
            <p>Here you can see and make edits to your mentor's profiles</p>
            <p><router-link class="btn btn-secondary" to="/mentors" role="button">View details »</router-link></p>
          </div>
          <div class="col-md-12">
            <h2>Scholars</h2>
            <p> Information regarding scholars, including timesheet data, can be found here</p>
            <p><router-link class="btn btn-secondary" to="/scholars" role="button">View details »</router-link></p>
          </div>
        </div>

        <hr>

      </div> <!-- /container -->

    </main>
</template>

<script>
export default {};
</script>

<style>
</style>
