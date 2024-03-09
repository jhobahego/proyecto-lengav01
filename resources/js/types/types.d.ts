export const activity_type = {
  ONLINE: 'online',
  PRESENCIAL: 'in-person'
};

export interface Event {
  id: number;
  title: string;
  manager: number;
  description: string;
  activity_type: activity_type;
  link?: string;
  location?: string;
  start: string;
  end?: string;
  duration: string;
  color: string;
}

export interface Project {
  id: number;
  title: string;
  description: string;
  general_objectives: string[];
  specific_objectives: string[];
  portrait_url: string;
  project_type: string;
  manager: number;
  start_date: string;
  end_date: string;
  project_status: string;
  project_link: string;
}

interface User {
  id: number;
  name: string;
  email: string;
  remember_token: string;
  profile_photo_path: string | null;
}
