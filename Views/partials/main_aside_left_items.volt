        {% if CxHelper.RoutesAllowed([
        'djbkc-dashboard-index',
        'djbkc-dashboard-categories',
        'djbkc-dashboard-tags',
        'djbkc-dashboard-collections',
        'djbkc-dashboard-assets'

        ]) %}
        <li class="">
            <a href="#"><i class="fa fa-lg fa-fw fa-camera-retro"></i> <span class="menu-item-parent">Kids-Corner</span></a>

            <ul>
            <li class="">
                 <a href="{{CxHelper.Route('djbkc-dashboard-assets')}}"><i class="fa fa-lg fa-fw"></i> <span class="menu-item-parent">Assets</span></a>
            </li>
            <li class="">
                  <a href="{{CxHelper.Route('djbkc-dashboard-categories')}}"><i class="fa fa-lg fa-fw"></i> <span class="menu-item-parent">Categories</span></a>
            </li>
            <li class="">
                   <a href="{{CxHelper.Route('djbkc-dashboard-tags')}}"><i class="fa fa-lg fa-fw"></i> <span class="menu-item-parent">Tags</span></a>
            </li>
            </li>
            <li class="">
                   <a href="{{CxHelper.Route('djbkc-dashboard-collections')}}"><i class="fa fa-lg fa-fw"></i> <span class="menu-item-parent">Collections</span></a>
            </li>
            </ul>
        </li>
        {% endif %}
