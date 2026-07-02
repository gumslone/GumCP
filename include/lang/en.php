<?php
// English (base language). All keys live here; other languages override.
return [
    // ── Navigation ──
    'nav.dashboard'   => 'Dashboard',
    'nav.services'    => 'Services',
    'nav.processes'   => 'Processes',
    'nav.phpinfo'     => 'PHP Info',
    'nav.actions'     => 'Actions',
    'nav.gpio'        => 'GPIO',
    'nav.buttons'     => 'Buttons',
    'nav.rpi'         => 'Raspberry Pi',
    'nav.docker'      => 'Docker',
    'nav.packages'    => 'Packages',
    'nav.logs'        => 'Logs',
    'nav.cron'        => 'Cron',
    'nav.users'       => 'Users',
    'nav.tehybug'     => 'TeHyBug',
    'nav.filemanager' => 'File Manager',
    'nav.database'    => 'Database Manager',
    'nav.system'      => 'System',
    'nav.reorder'     => 'Reorder menu',
    'nav.logout'      => 'Logout',
    'nav.language'    => 'Language',

    // ── Dashboard ──
    'dash.title'        => 'System Dashboard',
    'dash.cpu'          => 'CPU Usage',
    'dash.memory'       => 'Memory Usage',
    'dash.disk'         => 'Disk Usage',
    'dash.temp'         => 'CPU Temperature',

    'dash.service_status' => 'Service Status',
    'dash.services_none'  => 'No services configured.',
    'dash.power'          => 'Power & Throttling',
    'dash.healthy'        => 'Healthy — no under-voltage or throttling.',
    'dash.power_na'       => 'Not available',

    'dash.sysinfo'   => 'System Information',
    'dash.hostname'  => 'Hostname',
    'dash.os'        => 'Operating System',
    'dash.kernel'    => 'Kernel',
    'dash.cpu_label' => 'CPU',
    'dash.uptime'    => 'Uptime',
    'dash.datetime'  => 'Date / Time',
    'dash.processes' => 'Processes',
    'dash.load'      => 'Load Average',

    'dash.resource'   => 'Resource Usage',
    'dash.swap'       => 'Swap Usage',
    'dash.no_swap'    => 'No swap',

    'dash.mem_details' => 'Memory Details',
    'dash.total'       => 'Total',
    'dash.used'        => 'Used',
    'dash.buffers'     => 'Buffers',
    'dash.cached'      => 'Cached',

    'dash.network'     => 'Network',
    'net.interface'    => 'Interface',
    'net.ipv4'         => 'IPv4',
    'net.state'        => 'State',
    'net.signal'       => 'Signal',
    'net.received'     => 'Received',
    'net.transmitted'  => 'Transmitted',
    'net.none'         => 'No network interfaces found.',

    'dash.disk_info' => 'Disk Information',
    'dash.usb'       => 'Connected USB Devices',
    'dash.block'     => 'Block Devices',
    'dash.top'       => 'Top Processes (by Memory)',
    'dash.users'     => 'Active Users',

    // ── Common ──
    'common.refresh' => 'Refresh',
    'common.loading' => 'Loading…',
    'common.actions' => 'Actions',
    'common.name'    => 'Name',
    'common.status'  => 'Status',
    'common.save'    => 'Save',
    'common.add'     => 'Add',
    'common.delete'  => 'Delete',
    'common.command' => 'Command',

    // ── Services ──
    'svc.title'    => 'System Services',
    'svc.active'   => 'Active Services',
    'svc.inactive' => 'Inactive Services',
    'svc.unknown'  => 'Unknown Status',
    'svc.start'    => 'Start',
    'svc.stop'     => 'Stop',
    'svc.loading'  => 'Loading services…',

    // ── Processes ──
    'proc.title' => 'System Processes',
    'proc.kill'  => 'Kill',

    // ── Users & Groups ──
    'usr.title'        => 'Users & Groups',
    'usr.login_users'  => 'Login Users',
    'usr.all_accounts' => 'All System Accounts',
    'usr.groups'       => 'Groups',
    'usr.user'         => 'User',
    'usr.home'         => 'Home',
    'usr.shell'        => 'Shell',
    'usr.comment'      => 'Comment',
    'usr.members'      => 'Members',
    'usr.none'         => 'No login users found.',

    // ── Packages ──
    'pkg.title'       => 'Package Updates',
    'pkg.check'       => 'Check for updates',
    'pkg.upgrade'     => 'Upgrade all',
    'pkg.upgradable'  => 'Upgradable Packages',
    'pkg.package'     => 'Package',
    'pkg.installed'   => 'Installed',
    'pkg.available'   => 'Available',
    'pkg.uptodate'    => 'Everything is up to date.',

    // ── Logs ──
    'log.title'  => 'System Logs',
    'log.source' => 'Source',
    'log.lines'  => 'Lines',
    'log.filter' => 'Filter',
    'log.view'   => 'View',
    'log.select' => 'Select a source and click View.',

    // ── Cron ──
    'cron.title'          => 'Cron Jobs',
    'cron.add'            => 'Add Cron Job',
    'cron.when'           => 'When',
    'cron.expr'           => 'Schedule expression',
    'cron.command'        => 'Command to run',
    'cron.user_crontab'   => 'User Crontab',
    'cron.none'           => 'No cron jobs for this user.',
    'cron.custom'         => 'Custom schedule',
    'cron.invalid'        => 'Invalid schedule expression.',

    // ── Actions ──
    'act.title'         => 'Actions',
    'act.kill_pid'      => 'Kill process by PID',
    'act.kill_pname'    => 'Kill processes by name',
    'act.start_service' => 'Start service',
    'act.stop_service'  => 'Stop service',
    'act.kill'          => 'Kill',
    'act.start'         => 'Start',
    'act.stop'          => 'Stop',
    'act.system'        => 'System',
    'act.reboot'        => 'Reboot',
    'act.reboot_label'  => 'Reboot Raspberry Pi',
    'act.update_label'  => 'Update GumCP',
    'act.update'        => 'Update',
    'act.exec_label'    => 'Execute command',
    'act.exec'          => 'Execute',
    'act.background'    => 'Run in background (output saved to log file)',
    'act.syscheck'      => 'System Check',
    'act.syscheck_run'  => 'Run System Check',
    'act.useful'        => 'Useful commands',
    'act.bg_logs'       => 'Background command logs',

    // ── GPIO ──
    'gpio.title'  => 'GPIO Control',
    'gpio.legend' => 'Legend',

    // ── Buttons ──
    'btn.title' => 'Command Buttons',
    'btn.add'   => 'Add Command Button',

    // ── Docker ──
    'dock.containers' => 'Containers',
    'dock.images'     => 'Images',
    'dock.logs'       => 'Logs',

    // ── Raspberry Pi ──
    'rpi.firmware'    => 'Firmware & Clocks',
    'rpi.tempchart'   => 'Temperature & CPU Frequency',
    'rpi.interfaces'  => 'Interfaces',
    'rpi.bootconfig'  => 'Boot Configuration',
];
