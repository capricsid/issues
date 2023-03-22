{# Extend main template #}
{% extends "admin.volt" %}

{# Set Page Title #}
{% block title %}Kids Corner Categories{% endblock %}

{% block content %}
    <section id="widget-cx-record-list">
        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
                    <header>
                        <span class="widget-icon"><i class="fa fa-thumb-tack"></i></span>
                        <h2>Categories</h2>
                    </header>
                    <div role="content">
                        <div class="jarviswidget-editbox"></div>
                        <div class="widget-body no-padding">
                            {# Using width attribute for responsive table: http://www.datatables.net/examples/basic_init/flexible_width.html #}
                            <table id="cx-records-table" data-new-allowed="{{ ACL['CREATE'] }}" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="all">Category</th>
                                        <th class="min-mobile-l">Status</th>
                                        <th class="min-tablet">Parent Category</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section id="widget-edit-cx-record">
        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false">
                    <header class="edit-new edit" role="heading">
                        <span class="widget-icon"><i class="fa fa-pencil-square"></i></span>
                        <h2 class="edit">Edit Category</h2>
                        <h2 class="new">New Category</h2>
                        <span class="jarviswidget-loader">
                            <i class="fa fa-refresh fa-spin"></i>
                        </span>
                    </header>
                    <div id="cx-record-edit-div" role="content">
                      <div class="jarviswidget-editbox"></div>
                      <div class="widget-body no-padding">
                        <div id="cx-record-edit-messages" class="messages">
                          {# Container for alerts #}
                        </div>
                        <form id="cx-record-edit" class="smart-form" data-edit-allowed="{{ CxHelper.boolOrToString([ACL['EDIT']]) }}">
                          {{ KcCategoryForm.render("id") }}
                          <fieldset>
                            <div class="row">
                              <section class="col col-4">
                                <label class="label">{{ KcCategoryForm.getLabel("name") }}</label>
                                <label class="input">
                                  {{ KcCategoryForm.render("name", ["class": "form-control", "data-allow-edit": ACL['EDIT']]) }}
                                </label>
                              </section>
                              <section class="col col-4">
                                <label class="label">{{ KcCategoryForm.getLabel("status") }}</label>
                                <label class="input">
                                  {{ KcCategoryForm.render("status", ["class": "form-control", "data-allow-edit": ACL['EDIT']]) }}
                                </label>
                              </section>
                            </div>
                            <div class="row">
                              <section id="parent_category_select" class="col col-4">
                                <label class="label">{{ KcCategoryForm.getLabel("parent_category_id") }}</label>
                                <label class="input">
                                  {{ KcCategoryForm.render("parent_category_id", ["class": "select2", "data-allow-edit": ACL['EDIT']]) }}
                                </label>
                              </section>
                            </div>
                          </fieldset>
                          <footer>
                            <button class="btn btn-success cx-btn-submit" disabled type="submit">Save Category</button>
                            <button class="btn btn-default cx-btn-cancel" type="button">Cancel</button>
                          </footer>
                        </form>
                      </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
{% endblock %}

{% block page_js %}
  <script type="text/javascript">
    $('document').ready(function() {
      KcCategory();
    });
  </script>
{% endblock %}
