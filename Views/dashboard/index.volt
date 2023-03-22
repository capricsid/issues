{# Extend main template #}
{% extends "admin.volt" %}

{# Set Page Title#}
{% block title %}Dashboard - Kids Corner{% endblock %}

{% block content %}
<!-- Content -->
<div class="content container-fluid">
  <div class="page-header mb-3 pb-2">
    <div class="row justify-content">
      <div class="col-sm mb-3 mb-sm-0 ">
      <h1 class="page-header-title"><?php echo $this->CxAuth->getCurrentCxUserFullName(); ?>, Welcome to Kids-Corner Dashboard. You logged in last time on <?php echo $this->CxAuth->getCurrentCxUserLastLoginDate(); ?>. </h1>
      </div>
    </div>
  </div>
  <!-- Card -->
  <div class="card">
    <div class="card-body text-center py-4">
      <div class="row">
      </div>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Content -->
{% endblock %}