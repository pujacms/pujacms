{% extends master.tpl %}
{% block body %}
User Information:
<p>Email: {{ user.email }}</p>
<p>Role: {{ user.role }}</p>

{% endblock %}