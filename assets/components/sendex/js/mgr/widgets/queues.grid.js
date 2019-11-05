Sendex.grid.Queues = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'sendex-grid-queues'
        ,url: Sendex.config.connector_url
        ,baseParams: {
            action: 'mgr/queue/getlist'
        }
        ,fields: ['id', 'newsletter_id', 'subscriber_id', 'timestamp', 'email_to', 'email_subject', 'email_body', 'email_from', 'email_from_name', 'email_reply', 'newsletter']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,columns: [
            {header: _('sendex_queue_id'), dataIndex: 'id', width: 50}
            ,{header: _('sendex_newsletter'), dataIndex: 'newsletter', width: 100}
            ,{header: _('sendex_queue_email_to'), dataIndex: 'email_to', width: 75}
            ,{header: _('sendex_queue_email_body'), dataIndex: 'email_body', width: 100}
            ,{header: _('sendex_queue_email_subject'), dataIndex: 'email_subject', width: 100}
            ,{header: _('sendex_queue_email_from_name'), dataIndex: 'email_from_name', width: 100}
            ,{header: _('sendex_queue_email_reply'), dataIndex: 'email_reply', width: 100}
            ,{header: _('sendex_queue_email_from'), dataIndex: 'email_from', width: 100}
            ,{header: _('sendex_queue_timestamp'), dataIndex: 'timestamp', width: 75}
        ]
    });
    Sendex.grid.Queues.superclass.constructor.call(this,config);
};
Ext.extend(Sendex.grid.Queues, MODx.grid.Grid);
Ext.reg('sendex-grid-queues',Sendex.grid.Queues);