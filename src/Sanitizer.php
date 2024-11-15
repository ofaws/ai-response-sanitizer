<?php

namespace Ofaws\Sanitizer;

use Illuminate\Support\Facades\Storage;

class Sanitizer
{
    public function after(string $input, string $search): string
    {
        return str($input)->after($search)->trim(":; -\n\r")->replace('**', '')->toString();
    }

    public function between(string $input, string $from, string $to): string
    {
        return str($input)->between($from, $to)->trim(":; -\n\r")->replace('**', '')->toString();
    }

    public function checkIfImageFile(string $path): bool
    {
        return in_array(
            str($path)->afterLast('.')->toString(),
            ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']
        );
    }

    public function json(string $input): array|bool|null
    {
        return json_decode(str($input)
            ->whenStartsWith('```json', fn ($str) => $str
                ->replaceFirst('```json', '')
                ->replaceLast('```', '')
            )
            ->whenStartsWith('[{', fn ($str) => str_ends_with($str, ']}')
                ? $str->replaceLast(']}', ']}]')
                : $str
            )
            ->replace('\\', '\\\\')
            ->rtrim('.')
            ->rtrim(';')
            ->toString(), true);
    }

    public function lessonContent(?string $input, ?string $topic): string
    {
        if (! $input) {
            return 'AI failed to generate the content';
        }

        return str($input)
            ->whenStartsWith('# ', fn ($str) => $str
                ->replaceFirst('# '.$topic, '')
                ->ltrim()
            );
    }

    public function markdown(string $input): string
    {
        return str($input)
            ->whenStartsWith('```markdown', fn ($str) => $str
                ->replaceFirst('```markdown', '')
                ->replaceLast('```', '')
                ->trim()
            )->toString();
    }

    public function prompts(?string $input): string
    {
        if (! $input) {
            return '';
        }

        return str($input)
            ->whenStartsWith('```json', fn ($str) => $str
                ->replaceFirst('```json', '{')
                ->replaceLast('```', '}')
            )
            ->whenStartsWith('[{', fn ($str) => str_ends_with($str, ']}')
                ? $str->replaceLast('}', '')
                : $str
            )
            ->replace(["{\n[", "{\r\n["], '[')
            ->replace(["]\n}", "]\r\n}"], ']')
            ->replace("\r\n", '')
            ->replaceMatches('/\s+/', ' ')
            ->replaceMatches('/", }/', '"}')
            ->replaceMatches('/",}/', '"}')
            ->replace(['``` }', '```}'], '```"}')
            ->replace('"}}]', '"}]"')
            ->replace('\_', '_')
            ->replace('[^"]', '\"')
            ->rtrim('.;')
            ->toString();
    }

    public function sandboxUrl(string $path, string $content): string
    {
        if ($path === '#') {
            return preg_replace('/!?\[.*?\]\(sandbox:[^)]+\)/', '', $content);
        }

        return preg_replace('/\(sandbox:[^)]+\)/', '('.Storage::url($path).')', $content);
    }

    public function titleFromMd(string $input): string
    {
        return str($input)->betweenFirst('# ', "\n")->limit()->toString();
    }
}