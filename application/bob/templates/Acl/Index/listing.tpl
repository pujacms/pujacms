{% extends master.tpl %}
{% block body %}
User Listing
{% for user in users %}
Username: {{ user.username }}
{% endfor %}

{% endblock %}