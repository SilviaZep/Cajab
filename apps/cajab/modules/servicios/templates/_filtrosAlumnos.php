                             <div class = "col-xs-12 col-sm-6 col-md-3">
                             <div class = "col-xs-12">
                              <label for = "" class = "control-label col-xs-4">Ciclo escolar</label>
                              </div>
                                <div class = "form-group">                                  
                                    <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-offset-2 col-lg-8">
                                        <div class = "multisel-chk" id = "lst_location">
                                            <ul id = "new_filterby_location">
                                                {% for ciclos in ciclosEscolares %}
                                                    <li>
                                                        <input type = "checkbox" name = "loc_{{location.id}}" id = "loc_seccion.id" value = "seccion.id" onchange = "submitFilter()">
                                                        <label for = "loc_seccion.id">seccion.id</label>
                                                    </li>
                                                {% endfor %}
                                            </ul>
                                        </div>
                                        <label class = "checkAll" onchange = "submitFilter()">
                                            <input type = "checkbox">&nbsp;{%trans%}Select All{%endtrans%}
                                        </label>
                                    </div>
                                </div>
                            </div><!--end col-xs-6 col-sm-4-->
                            <div class = "col-xs-12 col-sm-6 col-md-3">
                             <div class = "col-xs-12">
                              <label for = "" class = "control-label col-xs-4">Seccion</label>
                              </div>
                                <div class = "form-group">                                  
                                    <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-offset-2 col-lg-8">
                                        <div class = "multisel-chk" id = "lst_location">
                                            <ul id = "new_filterby_location">
                                                {% for seccion in secciones %}
                                                    <li>
                                                        <input type = "checkbox" name = "loc_{{location.id}}" id = "loc_seccion.id" value = "seccion.id" onchange = "submitFilter()">
                                                        <label for = "loc_seccion.id">seccion.id</label>
                                                    </li>
                                                {% endfor %}
                                            </ul>
                                        </div>
                                        <label class = "checkAll" onchange = "submitFilter()">
                                            <input type = "checkbox">&nbsp;{%trans%}Select All{%endtrans%}
                                        </label>
                                    </div>
                                </div>
                            </div><!--end col-xs-6 col-sm-4-->
                              <div class = "col-xs-12 col-sm-6 col-md-3">
                            <div class = "col-xs-12">
                              <label class = "control-label col-xs-4">{% trans %}Grados{% endtrans %}</label>
                              </div>
                                <div class = "form-group">                                  
                                    <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-offset-2 col-lg-8">
                                        <div class = "multisel-chk" id = "lst_profile">
                                            <ul id = "new_profile">
                                                 {% for department in departments %}
                                                    <li>
                                                        <input type = "checkbox" name = "dep_{{department.id}}" id = "dep_{{department.id}}" value = "{{department.id}}" onchange = "submitFilter()">
                                                        <label for = "dep_{{department.id}}">{{department.name}}</label>
                                                    </li>
                                                {% endfor %}
                                            </ul>
                                        </div>
                                        <label class = "checkAll">
                                            <input type = "checkbox" onchange = "submitFilter()">&nbsp;{%trans%}Select All{%endtrans%}
                                        </label>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-xs-12 col-sm-4-->
                            <div class = "col-xs-12 col-sm-6 col-md-3">
                            <div class = "col-xs-12">
                              <label class = "control-label col-xs-4">{% trans %}Grupos{% endtrans %}</label>
                              </div>
                                <div class = "form-group">                                  
                                    <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-offset-2 col-lg-8">
                                        <div class = "multisel-chk" id = "lst_position">
                                            <ul id = "new_position">
                                                {% for position in positions %}
                                                    <li>
                                                        <input type = "checkbox" name = "pos_{{position.id}}" id = "pos_{{position.id}}" value = "{{position.id}}" onchange = "submitFilter()">
                                                        <label for = "pos_{{position.id}}">{{position.position}}</label>
                                                    </li>
                                                {% endfor %}
                                            </ul>
                                        </div>
                                        <label class = "checkAll" onchange = "submitFilter()">
                                            <input type = "checkbox">&nbsp;{%trans%}Select All{%endtrans%}
                                        </label>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-xs-12 col-sm-4-->
                            
                            