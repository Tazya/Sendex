Sendex.combo.Snippet = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'snippet'
        ,hiddenName: 'snippet'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['id','name']
        ,pageSize: 10
        ,hideMode: 'offsets'
        ,url: MODx.config.connector_url
        ,baseParams: {
            action: 'element/template/getlist'
            ,combo: 1
        }
    });
    Sendex.combo.Snippet.superclass.constructor.call(this,config);
};
Ext.extend(Sendex.combo.Snippet,MODx.combo.ComboBox);
Ext.reg('sendex-combo-snippet',Sendex.combo.Snippet);

Sendex.combo.User = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'user_id'
        ,fieldLabel: _('sendex_subscriber')
        ,hiddenName: config.name || 'user_id'
        ,displayField: 'username'
        ,valueField: 'id'
        ,anchor: '99%'
        ,fields: ['name', 'id', 'email']
        ,pageSize: 20
        ,url: MODx.modx23
            ? MODx.config.connector_url
            : MODx.config.connectors_url + 'security/group.php'
        ,baseParams: {
            action: MODx.modx23
                ? 'security/group/getlist'
                : 'getlist'
            ,combo: 0
        }
        ,editable: true
        ,allowBlank: true
        ,emptyText: _('sendex_select_user')
        ,tpl: new Ext.XTemplate('<tpl for=".">'
				+ '<div class="sendex-list-item">'
                + '<tpl if="id"><sup>({id})</sup></tpl>'
                    + '<strong>{name}</strong><br/>{email}</div></tpl>'
            ,{compiled: true})
        ,itemSelector: 'div.sendex-list-item'
    });
    Sendex.combo.User.superclass.constructor.call(this,config);
};
Ext.extend(Sendex.combo.User,MODx.combo.ComboBox);
Ext.reg('sendex-combo-user', Sendex.combo.User);

Sendex.combo.Newsletter = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'user_id'
        ,fieldLabel: _('sendex_newsletter')
        ,hiddenName: config.name || 'user_id'
        ,displayField: 'name'
        ,valueField: 'id'
        ,anchor: '99%'
        ,fields: ['id', 'name']
        ,pageSize: 20
        ,url: Sendex.config.connector_url
        ,editable: true
        ,allowBlank: true
        ,emptyText: _('sendex_select_newsletter')
        ,baseParams: {
            action: 'mgr/newsletter/getlist'
            ,combo: 1
        }
        ,tpl: new Ext.XTemplate(''
            + '<tpl for="."><div class="sendex-list-item">'
            + '<span><small>({id})</small> {name}</span>'
            + '</div></tpl>', {
                compiled: true
            })
        ,itemSelector: 'div.sendex-list-item'
    });
    Sendex.combo.Newsletter.superclass.constructor.call(this,config);
};
Ext.extend(Sendex.combo.Newsletter, MODx.combo.ComboBox);
Ext.reg('sendex-combo-newsletter', Sendex.combo.Newsletter);