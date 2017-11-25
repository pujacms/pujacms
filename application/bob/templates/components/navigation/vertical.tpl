<div class="easyui-accordion" data-options="multiple:true">
    {% for nav in navigation %}
        {% if nav.child %}
        <div class="navsub {% if nav.is_current %}menu-active selected{% endif %}"" title="{{ nav.name }}" data-options="collapsed:false">
            {% for navsub in nav.child %}
            <div><a class="easyui-link {% if navsub.is_current %}menu-active selected{% endif %}" href="{{ navsub.url }}">{{ navsub.name }}</a></div>
            {% endfor %}
        </div>
        {% endif %}
    {% endfor %}
</div>