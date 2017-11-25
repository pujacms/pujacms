{% for nav in navigation %}
{% if nav.child %}
<a href="#" class="easyui-menubutton {% if nav.is_current %}menu-active selected{% endif %}" data-options="menu:'#menu_{{ nav.id_configure_cmsmenu }}',plain:true,border:false">{{ nav.name }}</a>
<div class="navsub" id="menu_{{ nav.id_configure_cmsmenu }}">
    {% for navsub in nav.child %}
    <a class="easyui-link {% if navsub.is_current %}menu-active selected{% endif %}" href="{{ navsub.url }}">{{ navsub.name }}</a>
    {% endfor %}
</div>
{% endif %}
{% endfor %}
