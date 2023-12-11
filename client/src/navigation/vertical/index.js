export default [
  {
    title: "Dashboard",
    route: "dashboard",
    icon: "BarChart2Icon",
  },
  {
    title: "Home",
    route: "home",
    icon: "HomeIcon",
  },
  {
    title: "Patients",
    icon: "PlusIcon",
    children: [
      {
        title: "modules.patients.patients",
        icon: "LockIcon",
        route: "patients.index",
      },
      {
        title: "Accepted Patient",
        route: "child2",
      },
      {
        title: "Discharge Patient",
        route: "child2",
      },
    ],
  },
  {
    title: "Transactions",
    icon: "MonitorIcon",
    children: [
      {
        title: "Refferred Patient",
        route: "child1",
      },
      {
        title: "Refferal Patient",
        route: "child2",
      },
    ],
  },
  {
    title: "Reports",
    icon: "FileIcon",
    children: [
      {
        title: "24 Weeks AOG",
        route: "child1",
      },
      {
        title: "Transanction Report",
        route: "child2",
      },
    ],
  },
  {
    title: "PTS Manual",
    route: "",
    icon: "BookOpenIcon",
  },
  {
    title: "modules.roles.roles",
    icon: "LockIcon",
    route: "roles.index",
  },
  {
    title: "modules.users.users",
    icon: "UsersIcon",
    route: "users.index",
  },
  // {
  // 	title: 'Users & Roles',
  // 	icon: 'UsersIcon',
  // 	children: [
  // 		{
  // 			title: 'modules.roles.roles',
  // 			icon: 'LockIcon',
  // 			route: 'roles.index',
  // 		},
  // 		{
  // 			title: 'modules.users.users',
  // 			icon: 'UsersIcon',
  // 			route: 'users.index',
  // 		}
  // 	]
  // }
];
