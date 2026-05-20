import type { Course } from "./course"

export interface EnrollmentItem {
    id: number
    student_id: number
    progress: number,
    course_id: number
    video_id: number | null
    audio_id: number | null
    course: Course
    created_at: string
    updated_at: string
}
