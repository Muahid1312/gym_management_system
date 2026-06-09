import { useState } from 'react';
import { cn } from './utils/cn';
import { 
  Users, 
  Calendar, 
  DollarSign, 
  TrendingUp, 
  Dumbbell, 
  Clock,
  Menu,
  UserPlus,
  CalendarDays,
  CreditCard,
  UserCog,
  Activity,
  LogOut,
  Search,
  Plus,
  MoreVertical,
  CheckCircle,
  Edit,
  Trash2,
  Home,
  Bell,
  Settings as SettingsIcon
} from 'lucide-react';

// Types
interface Member {
  id: number;
  name: string;
  email: string;
  phone: string;
  plan: string;
  status: 'active' | 'inactive';
  joinDate: string;
  avatar: string;
}

interface ClassSchedule {
  id: number;
  name: string;
  trainer: string;
  time: string;
  day: string;
  capacity: number;
  enrolled: number;
}

interface Payment {
  id: number;
  member: string;
  amount: number;
  date: string;
  status: 'paid' | 'pending' | 'overdue';
  plan: string;
}

interface Trainer {
  id: number;
  name: string;
  specialty: string;
  phone: string;
  email: string;
  status: 'active' | 'inactive';
  avatar: string;
}

// Sample Data
const sampleMembers: Member[] = [
  { id: 1, name: 'John Doe', email: 'john@email.com', phone: '+1234567890', plan: 'Premium', status: 'active', joinDate: '2024-01-15', avatar: 'https://i.pravatar.cc/150?u=1' },
  { id: 2, name: 'Sarah Smith', email: 'sarah@email.com', phone: '+1234567891', plan: 'Standard', status: 'active', joinDate: '2024-02-20', avatar: 'https://i.pravatar.cc/150?u=2' },
  { id: 3, name: 'Mike Johnson', email: 'mike@email.com', phone: '+1234567892', plan: 'Premium', status: 'inactive', joinDate: '2024-01-10', avatar: 'https://i.pravatar.cc/150?u=3' },
  { id: 4, name: 'Emily Davis', email: 'emily@email.com', phone: '+1234567893', plan: 'Basic', status: 'active', joinDate: '2024-03-05', avatar: 'https://i.pravatar.cc/150?u=4' },
  { id: 5, name: 'Chris Wilson', email: 'chris@email.com', phone: '+1234567894', plan: 'Standard', status: 'active', joinDate: '2024-02-28', avatar: 'https://i.pravatar.cc/150?u=5' },
];

const sampleClasses: ClassSchedule[] = [
  { id: 1, name: 'Morning Yoga', trainer: 'Lisa Chen', time: '06:00 AM', day: 'Monday', capacity: 20, enrolled: 15 },
  { id: 2, name: 'HIIT Training', trainer: 'Mark Brown', time: '07:00 AM', day: 'Monday', capacity: 15, enrolled: 12 },
  { id: 3, name: 'Cardio Blast', trainer: 'Sarah Lee', time: '05:00 PM', day: 'Monday', capacity: 25, enrolled: 20 },
  { id: 4, name: 'Strength Training', trainer: 'John Miller', time: '06:00 PM', day: 'Tuesday', capacity: 12, enrolled: 10 },
  { id: 5, name: 'Pilates', trainer: 'Emma Wilson', time: '08:00 AM', day: 'Wednesday', capacity: 18, enrolled: 14 },
];

const samplePayments: Payment[] = [
  { id: 1, member: 'John Doe', amount: 99.99, date: '2024-12-01', status: 'paid', plan: 'Premium' },
  { id: 2, member: 'Sarah Smith', amount: 59.99, date: '2024-12-02', status: 'paid', plan: 'Standard' },
  { id: 3, member: 'Mike Johnson', amount: 29.99, date: '2024-12-03', status: 'pending', plan: 'Basic' },
  { id: 4, member: 'Emily Davis', amount: 99.99, date: '2024-12-04', status: 'overdue', plan: 'Premium' },
  { id: 5, member: 'Chris Wilson', amount: 59.99, date: '2024-12-05', status: 'paid', plan: 'Standard' },
];

const sampleTrainers: Trainer[] = [
  { id: 1, name: 'Lisa Chen', specialty: 'Yoga & Pilates', phone: '+1234567895', email: 'lisa@gym.com', status: 'active', avatar: 'https://i.pravatar.cc/150?u=10' },
  { id: 2, name: 'Mark Brown', specialty: 'HIIT & Cardio', phone: '+1234567896', email: 'mark@gym.com', status: 'active', avatar: 'https://i.pravatar.cc/150?u=11' },
  { id: 3, name: 'Sarah Lee', specialty: 'Cardio & Dance', phone: '+1234567897', email: 'sarah@gym.com', status: 'active', avatar: 'https://i.pravatar.cc/150?u=12' },
  { id: 4, name: 'John Miller', specialty: 'Strength & Bodybuilding', phone: '+1234567898', email: 'john@gym.com', status: 'inactive', avatar: 'https://i.pravatar.cc/150?u=13' },
];

// Stat Card Component
function StatCard({ title, value, icon: Icon, trend, color }: { title: string; value: string; icon: any; trend?: string; color: string }) {
  return (
    <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
      <div className="flex items-center justify-between">
        <div>
          <p className="text-sm text-gray-500 mb-1">{title}</p>
          <h3 className="text-3xl font-bold text-gray-900">{value}</h3>
          {trend && <p className="text-sm text-green-600 mt-2 flex items-center gap-1"><TrendingUp className="w-4 h-4" />{trend}</p>}
        </div>
        <div className={cn("p-4 rounded-2xl", color)}>
          <Icon className="w-8 h-8 text-white" />
        </div>
      </div>
    </div>
  );
}

// Navigation Component
function Sidebar({ activeTab, setActiveTab, isOpen, setIsOpen }: { activeTab: string; setActiveTab: (tab: string) => void; isOpen: boolean; setIsOpen: (open: boolean) => void }) {
  const menuItems = [
    { id: 'dashboard', label: 'Dashboard', icon: Home },
    { id: 'members', label: 'Members', icon: Users },
    { id: 'schedule', label: 'Schedule', icon: Calendar },
    { id: 'payments', label: 'Payments', icon: DollarSign },
    { id: 'trainers', label: 'Trainers', icon: UserCog },
    { id: 'attendance', label: 'Attendance', icon: Activity },
    { id: 'settings', label: 'Settings', icon: SettingsIcon },
  ];

  return (
    <>
      {/* Mobile Overlay */}
      {isOpen && <div className="fixed inset-0 bg-black/50 z-40 lg:hidden" onClick={() => setIsOpen(false)} />}
      
      {/* Sidebar */}
      <aside className={cn(
        "fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 lg:transform-none",
        isOpen ? "translate-x-0" : "-translate-x-full lg:translate-x-0"
      )}>
        <div className="flex flex-col h-full">
          {/* Logo */}
          <div className="p-6 border-b border-gray-100">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center">
                <Dumbbell className="w-6 h-6 text-white" />
              </div>
              <div>
                <h1 className="text-xl font-bold text-gray-900">FitPro</h1>
                <p className="text-xs text-gray-500">Gym Management</p>
              </div>
            </div>
          </div>

          {/* Navigation */}
          <nav className="flex-1 p-4 space-y-1 overflow-y-auto">
            {menuItems.map((item) => (
              <button
                key={item.id}
                onClick={() => { setActiveTab(item.id); setIsOpen(false); }}
                className={cn(
                  "w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all",
                  activeTab === item.id
                    ? "bg-gradient-to-r from-orange-500 to-red-600 text-white shadow-lg shadow-orange-200"
                    : "text-gray-600 hover:bg-gray-100"
                )}
              >
                <item.icon className="w-5 h-5" />
                {item.label}
              </button>
            ))}
          </nav>

          {/* User Profile */}
          <div className="p-4 border-t border-gray-100">
            <div className="flex items-center gap-3 p-3 rounded-xl bg-gray-50">
              <img src="https://i.pravatar.cc/150?u=admin" alt="Admin" className="w-10 h-10 rounded-full" />
              <div className="flex-1">
                <p className="text-sm font-medium text-gray-900">Admin User</p>
                <p className="text-xs text-gray-500">Manager</p>
              </div>
              <LogOut className="w-5 h-5 text-gray-400 cursor-pointer hover:text-red-500" />
            </div>
          </div>
        </div>
      </aside>
    </>
  );
}

// Header Component
function Header({ title, setIsOpen }: { title: string; setIsOpen: (open: boolean) => void }) {
  return (
    <header className="bg-white border-b border-gray-200 px-6 py-4">
      <div className="flex items-center justify-between">
        <div className="flex items-center gap-4">
          <button onClick={() => setIsOpen(true)} className="lg:hidden p-2 hover:bg-gray-100 rounded-lg">
            <Menu className="w-6 h-6" />
          </button>
          <h1 className="text-2xl font-bold text-gray-900">{title}</h1>
        </div>
        <div className="flex items-center gap-4">
          <div className="relative">
            <Search className="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" />
            <input
              type="text"
              placeholder="Search..."
              className="pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 w-64"
            />
          </div>
          <button className="relative p-2 hover:bg-gray-100 rounded-lg">
            <Bell className="w-6 h-6 text-gray-600" />
            <span className="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
        </div>
      </div>
    </header>
  );
}

// Dashboard Component
function Dashboard() {
  const stats = [
    { title: 'Total Members', value: '254', icon: Users, trend: '+12% this month', color: 'bg-gradient-to-br from-blue-500 to-blue-600' },
    { title: 'Monthly Revenue', value: '$24,580', icon: DollarSign, trend: '+8% this month', color: 'bg-gradient-to-br from-green-500 to-green-600' },
    { title: 'Active Classes', value: '28', icon: Calendar, trend: '+5 this week', color: 'bg-gradient-to-br from-purple-500 to-purple-600' },
    { title: 'Attendance Rate', value: '87%', icon: Activity, trend: '+3% this month', color: 'bg-gradient-to-br from-orange-500 to-orange-600' },
  ];

  return (
    <div className="space-y-6">
      {/* Stats Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats.map((stat, index) => (
          <StatCard key={index} {...stat} />
        ))}
      </div>

      {/* Recent Activity & Quick Actions */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Recent Members */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div className="flex items-center justify-between mb-4">
            <h2 className="text-lg font-semibold text-gray-900">Recent Members</h2>
            <button className="text-sm text-orange-600 font-medium hover:text-orange-700">View All</button>
          </div>
          <div className="space-y-4">
            {sampleMembers.slice(0, 4).map((member) => (
              <div key={member.id} className="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-xl transition-colors">
                <img src={member.avatar} alt={member.name} className="w-12 h-12 rounded-full" />
                <div className="flex-1">
                  <h3 className="font-medium text-gray-900">{member.name}</h3>
                  <p className="text-sm text-gray-500">{member.plan} Plan</p>
                </div>
                <span className={cn(
                  "px-3 py-1 rounded-full text-xs font-medium",
                  member.status === 'active' ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700"
                )}>
                  {member.status}
                </span>
              </div>
            ))}
          </div>
        </div>

        {/* Upcoming Classes */}
        <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div className="flex items-center justify-between mb-4">
            <h2 className="text-lg font-semibold text-gray-900">Upcoming Classes</h2>
            <button className="text-sm text-orange-600 font-medium hover:text-orange-700">View Schedule</button>
          </div>
          <div className="space-y-4">
            {sampleClasses.slice(0, 4).map((classItem) => (
              <div key={classItem.id} className="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-xl transition-colors">
                <div className="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                  <Clock className="w-6 h-6 text-orange-600" />
                </div>
                <div className="flex-1">
                  <h3 className="font-medium text-gray-900">{classItem.name}</h3>
                  <p className="text-sm text-gray-500">{classItem.trainer} • {classItem.time}</p>
                </div>
                <div className="text-right">
                  <p className="text-sm font-medium text-gray-900">{classItem.enrolled}/{classItem.capacity}</p>
                  <p className="text-xs text-gray-500">enrolled</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* Revenue Chart Placeholder */}
      <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h2 className="text-lg font-semibold text-gray-900 mb-4">Revenue Overview</h2>
        <div className="h-64 flex items-end justify-between gap-2">
          {['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'].map((month, index) => {
            const heights = [60, 75, 55, 80, 70, 90, 85, 95, 88, 92, 85, 100];
            return (
              <div key={month} className="flex-1 flex flex-col items-center gap-2">
                <div
                  className="w-full bg-gradient-to-t from-orange-500 to-orange-400 rounded-t-lg transition-all hover:from-orange-600 hover:to-orange-500"
                  style={{ height: `${heights[index]}%` }}
                ></div>
                <span className="text-xs text-gray-500">{month}</span>
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );
}

// Members Component
function Members() {
  const [members] = useState<Member[]>(sampleMembers);
  const [searchTerm, setSearchTerm] = useState('');

  const filteredMembers = members.filter(m =>
    m.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    m.email.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div className="space-y-6">
      {/* Actions Bar */}
      <div className="flex flex-col sm:flex-row gap-4 justify-between">
        <div className="relative flex-1 max-w-md">
          <Search className="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" />
          <input
            type="text"
            placeholder="Search members..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500"
          />
        </div>
        <button className="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl font-medium hover:shadow-lg transition-all">
          <UserPlus className="w-5 h-5" />
          Add Member
        </button>
      </div>

      {/* Members Table */}
      <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50 border-b border-gray-200">
              <tr>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Member</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Contact</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Plan</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Join Date</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100">
              {filteredMembers.map((member) => (
                <tr key={member.id} className="hover:bg-gray-50 transition-colors">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                      <img src={member.avatar} alt={member.name} className="w-10 h-10 rounded-full" />
                      <div>
                        <p className="font-medium text-gray-900">{member.name}</p>
                        <p className="text-sm text-gray-500">{member.email}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4 text-sm text-gray-600">{member.phone}</td>
                  <td className="px-6 py-4">
                    <span className="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                      {member.plan}
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <span className={cn(
                      "px-3 py-1 rounded-full text-sm font-medium",
                      member.status === 'active' ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700"
                    )}>
                      {member.status}
                    </span>
                  </td>
                  <td className="px-6 py-4 text-sm text-gray-600">{member.joinDate}</td>
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-2">
                      <button className="p-2 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors">
                        <Edit className="w-4 h-4" />
                      </button>
                      <button className="p-2 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                        <Trash2 className="w-4 h-4" />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}

// Schedule Component
function Schedule() {
  const [classes] = useState<ClassSchedule[]>(sampleClasses);
  const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <div className="flex gap-2">
          {days.map((day) => (
            <button
              key={day}
              className="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-orange-50 hover:text-orange-600 hover:border-orange-200 transition-colors"
            >
              {day.slice(0, 3)}
            </button>
          ))}
        </div>
        <button className="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl font-medium hover:shadow-lg transition-all">
          <Plus className="w-5 h-5" />
          Add Class
        </button>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {classes.map((classItem) => (
          <div key={classItem.id} className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all hover:border-orange-200">
            <div className="flex items-start justify-between mb-4">
              <div className="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center">
                <Dumbbell className="w-6 h-6 text-white" />
              </div>
              <button className="p-2 hover:bg-gray-100 rounded-lg">
                <MoreVertical className="w-5 h-5 text-gray-400" />
              </button>
            </div>
            <h3 className="text-lg font-semibold text-gray-900 mb-2">{classItem.name}</h3>
            <p className="text-sm text-gray-500 mb-4">{classItem.trainer}</p>
            <div className="space-y-2">
              <div className="flex items-center gap-2 text-sm text-gray-600">
                <CalendarDays className="w-4 h-4" />
                {classItem.day}
              </div>
              <div className="flex items-center gap-2 text-sm text-gray-600">
                <Clock className="w-4 h-4" />
                {classItem.time}
              </div>
              <div className="flex items-center gap-2 text-sm text-gray-600">
                <Users className="w-4 h-4" />
                {classItem.enrolled} / {classItem.capacity} enrolled
              </div>
            </div>
            <div className="mt-4 pt-4 border-t border-gray-100 flex gap-2">
              <button className="flex-1 px-4 py-2 bg-orange-100 text-orange-700 rounded-lg text-sm font-medium hover:bg-orange-200 transition-colors">
                Edit
              </button>
              <button className="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                View Roster
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

// Payments Component
function Payments() {
  const [payments] = useState<Payment[]>(samplePayments);

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'paid': return 'bg-green-100 text-green-700';
      case 'pending': return 'bg-yellow-100 text-yellow-700';
      case 'overdue': return 'bg-red-100 text-red-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  return (
    <div className="space-y-6">
      <div className="flex flex-col sm:flex-row gap-4 justify-between">
        <div className="flex gap-4">
          <button className="px-4 py-2 text-sm font-medium text-orange-600 bg-orange-50 border border-orange-200 rounded-lg">
            All Payments
          </button>
          <button className="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
            Pending
          </button>
          <button className="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
            Overdue
          </button>
        </div>
        <button className="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl font-medium hover:shadow-lg transition-all">
          <CreditCard className="w-5 h-5" />
          Record Payment
        </button>
      </div>

      <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50 border-b border-gray-200">
              <tr>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Payment ID</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Member</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Plan</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100">
              {payments.map((payment) => (
                <tr key={payment.id} className="hover:bg-gray-50 transition-colors">
                  <td className="px-6 py-4 text-sm text-gray-600">#PAY-{payment.id.toString().padStart(4, '0')}</td>
                  <td className="px-6 py-4 font-medium text-gray-900">{payment.member}</td>
                  <td className="px-6 py-4">
                    <span className="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                      {payment.plan}
                    </span>
                  </td>
                  <td className="px-6 py-4 font-semibold text-gray-900">${payment.amount.toFixed(2)}</td>
                  <td className="px-6 py-4 text-sm text-gray-600">{payment.date}</td>
                  <td className="px-6 py-4">
                    <span className={cn("px-3 py-1 rounded-full text-sm font-medium", getStatusColor(payment.status))}>
                      {payment.status}
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-2">
                      <button className="p-2 hover:bg-green-100 text-green-600 rounded-lg transition-colors">
                        <CheckCircle className="w-4 h-4" />
                      </button>
                      <button className="p-2 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors">
                        <Edit className="w-4 h-4" />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}

// Trainers Component
function Trainers() {
  const [trainers] = useState<Trainer[]>(sampleTrainers);

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <p className="text-gray-600">Manage your gym trainers and their schedules</p>
        <button className="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl font-medium hover:shadow-lg transition-all">
          <UserPlus className="w-5 h-5" />
          Add Trainer
        </button>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {trainers.map((trainer) => (
          <div key={trainer.id} className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
            <div className="flex items-start justify-between mb-4">
              <img src={trainer.avatar} alt={trainer.name} className="w-16 h-16 rounded-full" />
              <span className={cn(
                "px-3 py-1 rounded-full text-xs font-medium",
                trainer.status === 'active' ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700"
              )}>
                {trainer.status}
              </span>
            </div>
            <h3 className="text-lg font-semibold text-gray-900 mb-1">{trainer.name}</h3>
            <p className="text-sm text-orange-600 font-medium mb-4">{trainer.specialty}</p>
            <div className="space-y-2 mb-4">
              <div className="flex items-center gap-2 text-sm text-gray-600">
                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                {trainer.phone}
              </div>
              <div className="flex items-center gap-2 text-sm text-gray-600">
                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                {trainer.email}
              </div>
            </div>
            <div className="flex gap-2">
              <button className="flex-1 px-4 py-2 bg-orange-100 text-orange-700 rounded-lg text-sm font-medium hover:bg-orange-200 transition-colors">
                View Profile
              </button>
              <button className="p-2 hover:bg-gray-100 text-gray-600 rounded-lg transition-colors">
                <MoreVertical className="w-5 h-5" />
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

// Attendance Component
function Attendance() {
  const today = new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

  return (
    <div className="space-y-6">
      <div className="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl p-6 text-white">
        <h2 className="text-2xl font-bold mb-2">Today's Attendance</h2>
        <p className="text-orange-100">{today}</p>
        <div className="grid grid-cols-3 gap-4 mt-6">
          <div className="bg-white/20 backdrop-blur rounded-xl p-4">
            <p className="text-3xl font-bold">142</p>
            <p className="text-sm text-orange-100">Checked In</p>
          </div>
          <div className="bg-white/20 backdrop-blur rounded-xl p-4">
            <p className="text-3xl font-bold">12</p>
            <p className="text-sm text-orange-100">Pending</p>
          </div>
          <div className="bg-white/20 backdrop-blur rounded-xl p-4">
            <p className="text-3xl font-bold">87%</p>
            <p className="text-sm text-orange-100">Attendance Rate</p>
          </div>
        </div>
      </div>

      <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div className="p-6 border-b border-gray-200">
          <h3 className="text-lg font-semibold text-gray-900">Member Check-ins</h3>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50 border-b border-gray-200">
              <tr>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Member</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Check-in Time</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Class</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                <th className="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100">
              {sampleMembers.slice(0, 5).map((member, index) => (
                <tr key={member.id} className="hover:bg-gray-50 transition-colors">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                      <img src={member.avatar} alt={member.name} className="w-10 h-10 rounded-full" />
                      <span className="font-medium text-gray-900">{member.name}</span>
                    </div>
                  </td>
                  <td className="px-6 py-4 text-sm text-gray-600">{String(7 + index).padStart(2, '0')}:30 AM</td>
                  <td className="px-6 py-4 text-sm text-gray-600">{sampleClasses[index % sampleClasses.length].name}</td>
                  <td className="px-6 py-4">
                    <span className="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                      Checked In
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <button className="p-2 hover:bg-orange-100 text-orange-600 rounded-lg transition-colors">
                      <MoreVertical className="w-4 h-4" />
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}

// Settings Component
function SettingsPage() {
  return (
    <div className="space-y-6 max-w-4xl">
      <div className="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div className="p-6 border-b border-gray-200">
          <h2 className="text-xl font-semibold text-gray-900">General Settings</h2>
        </div>
        <div className="p-6 space-y-6">
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">Gym Name</label>
            <input type="text" defaultValue="FitPro Gym" className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500" />
          </div>
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" defaultValue="info@fitprogym.com" className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500" />
          </div>
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">Phone</label>
            <input type="tel" defaultValue="+1 (555) 123-4567" className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500" />
          </div>
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">Address</label>
            <textarea rows={3} defaultValue="123 Fitness Street, Health City, HC 12345" className="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none" />
          </div>
          <button className="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl font-medium hover:shadow-lg transition-all">
            Save Changes
          </button>
        </div>
      </div>

      <div className="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div className="p-6 border-b border-gray-200">
          <h2 className="text-xl font-semibold text-gray-900">Membership Plans</h2>
        </div>
        <div className="p-6 space-y-4">
          {['Basic', 'Standard', 'Premium'].map((plan, index) => (
            <div key={plan} className="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
              <div>
                <h3 className="font-medium text-gray-900">{plan} Plan</h3>
                <p className="text-sm text-gray-500">${[29.99, 59.99, 99.99][index]} / month</p>
              </div>
              <div className="flex gap-2">
                <button className="px-4 py-2 bg-orange-100 text-orange-700 rounded-lg text-sm font-medium hover:bg-orange-200">
                  Edit
                </button>
                <button className="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200">
                  Delete
                </button>
              </div>
            </div>
          ))}
          <button className="w-full px-6 py-3 border-2 border-dashed border-gray-300 text-gray-600 rounded-xl font-medium hover:border-orange-500 hover:text-orange-600 transition-colors">
            + Add New Plan
          </button>
        </div>
      </div>
    </div>
  );
}

// Main App Component
export default function App() {
  const [activeTab, setActiveTab] = useState('dashboard');
  const [sidebarOpen, setSidebarOpen] = useState(false);

  const renderContent = () => {
    switch (activeTab) {
      case 'dashboard': return <Dashboard />;
      case 'members': return <Members />;
      case 'schedule': return <Schedule />;
      case 'payments': return <Payments />;
      case 'trainers': return <Trainers />;
      case 'attendance': return <Attendance />;
      case 'settings': return <SettingsPage />;
      default: return <Dashboard />;
    }
  };

  const getTitle = () => {
    const titles: { [key: string]: string } = {
      dashboard: 'Dashboard',
      members: 'Members',
      schedule: 'Class Schedule',
      payments: 'Payments',
      trainers: 'Trainers',
      attendance: 'Attendance',
      settings: 'Settings',
    };
    return titles[activeTab] || 'Dashboard';
  };

  return (
    <div className="flex h-screen bg-gray-50">
      <Sidebar activeTab={activeTab} setActiveTab={setActiveTab} isOpen={sidebarOpen} setIsOpen={setSidebarOpen} />
      
      <div className="flex-1 flex flex-col overflow-hidden">
        <Header title={getTitle()} setIsOpen={setSidebarOpen} />
        
        <main className="flex-1 overflow-y-auto p-6">
          {renderContent()}
        </main>
      </div>
    </div>
  );
}
